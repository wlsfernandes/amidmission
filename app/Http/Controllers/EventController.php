<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\SystemLogger;
use App\Helpers\S3;
use Throwable;

class EventController extends BaseController
{

    /**
     * Public: list all published events
     * URL: /our-events
     */
    public function indexPublic()
    {
        $events = Event::visible()
            ->orderBy('event_date')
            ->get();

        return view('frontend.events.index', compact('events'));
    }

    /**
     * Public: display a single event by slug
     * URL: /event/{slug}
     */
    public function display(Event $event)
    {
        abort_unless($event->is_published, 404);

        return view('frontend.events.show', compact('event'));
    }


    /**
     * List all events (published + drafts).
     */
    public function index()
    {
        $events = Event::orderByDesc('event_date')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.events.form');
    }

    /**
     * Store new event.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_es' => 'nullable|string',
            'event_date' => 'nullable|date',
            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',
            'is_published' => 'nullable|boolean',
            'image_url' => 'nullable|string|max:255',
            'file_url_en' => 'nullable|string|max:255',
            'file_url_es' => 'nullable|string|max:255',
            'external_link' => 'nullable|url|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Event::create([
                    'title_en' => $request->title_en,
                    'title_es' => $request->title_es,
                    'content_en' => $request->content_en,
                    'content_es' => $request->content_es,
                    'event_date' => $request->event_date,
                    'publish_start_at' => $request->publish_start_at,
                    'publish_end_at' => $request->publish_end_at,
                    'is_published' => (bool) $request->is_published,
                    'image_url' => $request->image_url,
                    'file_url_en' => $request->file_url_en,
                    'file_url_es' => $request->file_url_es,
                    'external_link' => $request->external_link,
                ]);
            });
            SystemLogger::log(
                'Event created',
                'info',
                'events.store',
                [
                    'email' => $request->email,
                    'roles' => $request->roles ?? [],
                ]
            );
            return redirect()
                ->route('events.index')
                ->with('success', 'Event created successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Event creation failed',
                'error',
                'events.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );
            return back()
                ->withInput()
                ->with('error', 'Failed to create event.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(Event $event)
    {
        return view('admin.events.form', compact('event'));
    }

    /**
     * Update event.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_es' => 'nullable|string',
            'event_date' => 'nullable|date',
            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',
            'is_published' => 'nullable|boolean',
            'image_url' => 'nullable|string|max:255',
            'file_url_en' => 'nullable|string|max:255',
            'file_url_es' => 'nullable|string|max:255',
            'external_link' => 'nullable|url|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $event) {
                $event->update($request->only([
                    'title_en',
                    'title_es',
                    'content_en',
                    'content_es',
                    'event_date',
                    'publish_start_at',
                    'publish_end_at',
                    'is_published',
                    'image_url',
                    'file_url_en',
                    'file_url_es',
                    'external_link',
                ]));
            });
            SystemLogger::log(
                'Event created',
                'info',
                'events.update',
                [
                    'email' => $request->email,
                    'roles' => $request->roles ?? [],
                ]
            );
            return redirect()
                ->route('events.index')
                ->with('success', 'Event updated successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Event creation failed',
                'error',
                'events.update',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->with('error', 'Failed to update event.');
        }
    }

    /**
     * Delete event.
     */
    public function destroy(Event $event)
    {
        try {
            if (!empty($event->image_url)) {
                S3::delete($event->image_url);
            }

            // 🔥 Delete English file if exists
            if (!empty($event->file_url_en)) {
                S3::delete($event->file_url_en);
            }

            // 🔥 Delete Spanish file if exists
            if (!empty($event->file_url_es)) {
                S3::delete($event->file_url_es);
            }
            $event->delete();

            SystemLogger::log(
                'Event deleted',
                'info',
                'events.delete',
                [
                    'roles' => $request->roles ?? [],
                ]
            );
            return redirect()
                ->route('events.index')
                ->with('success', 'Event deleted successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Event deletion failed',
                'error',
                'events.delete',
                [
                    'exception' => $e->getMessage(),
                ]
            );
            return back()->with('error', 'Failed to delete event.');
        }
    }
}
