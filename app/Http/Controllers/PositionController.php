<?php
namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Position;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;

class PositionController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: keep before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title_en'         => ['required', 'string', 'max:255'],
            'title_es'         => ['nullable', 'string', 'max:255'],

            'content_en'       => ['nullable', 'string'],
            'content_es'       => ['nullable', 'string'],

            'image_url'        => ['nullable', 'string'],
            'file_url_en'      => ['nullable', 'string'],
            'file_url_es'      => ['nullable', 'string'],

            'external_link'    => ['nullable', 'url'],

            'is_published'     => ['nullable', 'boolean'],
            'publish_start_at' => ['nullable', 'date'],
            'publish_end_at'   => ['nullable', 'date'],
        ]);
    }

    public function indexPublic()
    {
        $positions = Position::where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('publish_start_at')
                    ->orWhere('publish_start_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('publish_end_at')
                    ->orWhere('publish_end_at', '>=', now());
            })
            ->orderByDesc('created_at')
            ->get();

        return view('frontend.positions.index', compact('positions'));
    }

    public function display($slug)
    {
        $position = Position::where('slug', $slug)->firstOrFail();

        // If the position is not published, show 404
        if (! $position->is_published ||
            ($position->publish_start_at && $position->publish_start_at > now()) ||
            ($position->publish_end_at && $position->publish_end_at < now())) {
            abort(404);
        }

        return view('frontend.positions.display', compact('position'));
    }

    /**
     * Display a listing of positions.
     */
    public function index()
    {
        $positions = Position::orderByDesc('created_at')->get();

        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new position.
     */
    public function create()
    {
        return view('admin.positions.form');
    }

    /**
     * Store a newly created position.
     */
    public function store(Request $request)
    {
        // ✅ Validation first (do NOT wrap in try/catch)
        $data = $this->validatedData($request);

        try {
            $position = Position::create($data);

            SystemLogger::log(
                'Position created',
                'info',
                'positions.store',
                [
                    'position_id' => $position->id,
                    'email'       => $request->email,
                ]
            );

            return redirect()
                ->route('positions.index')
                ->with('success', 'Position created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Position creation failed',
                'error',
                'positions.store',
                [
                    'exception' => $e->getMessage(),
                    'email'     => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create position.');
        }
    }

    /**
     * Show the form for editing the specified position.
     */
    public function edit(Position $position)
    {
        return view('admin.positions.form', compact('position'));
    }

    /**
     * Update the specified position.
     */
    public function update(Request $request, Position $position)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $position->update($data);

            SystemLogger::log(
                'Position updated',
                'info',
                'positions.update',
                [
                    'position_id' => $position->id,
                    'email'       => $request->email,
                ]
            );

            return redirect()
                ->route('positions.index')
                ->with('success', 'Position updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Position update failed',
                'error',
                'positions.update',
                [
                    'position_id' => $position->id,
                    'exception'   => $e->getMessage(),
                    'email'       => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update position.');
        }
    }

    /**
     * Remove the specified position.
     */
    public function destroy(Position $position)
    {
        try {
            // Cleanup associated S3 assets
            if (! empty($position->image_url)) {
                S3::delete($position->image_url);
            }

            if (! empty($position->file_url_en)) {
                S3::delete($position->file_url_en);
            }

            if (! empty($position->file_url_es)) {
                S3::delete($position->file_url_es);
            }

            $position->delete();

            SystemLogger::log(
                'Position deleted',
                'warning',
                'positions.delete',
                [
                    'position_id' => $position->id,
                    'email'       => request()->email,
                ]
            );

            return redirect()
                ->route('positions.index')
                ->with('success', 'Position deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Position deletion failed',
                'error',
                'positions.delete',
                [
                    'position_id' => $position->id,
                    'exception'   => $e->getMessage(),
                    'email'       => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete position.');
        }
    }
}
