<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use App\Enums\SocialPlatform;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use App\Services\SystemLogger;
use Exception;

class SocialLinkController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: before store/update)
     */
    protected function validatedData(Request $request, ?SocialLink $socialLink = null): array
    {
        return $request->validate([
            'platform' => [
                'required',
                new Enum(SocialPlatform::class),
                function ($attribute, $value, $fail) use ($socialLink) {
                    $query = SocialLink::where('platform', $value);
                    if ($socialLink) {
                        $query->where('id', '!=', $socialLink->id);
                    }
                    if ($query->exists()) {
                        $fail('This social platform already exists.');
                    }
                }
            ],

            'url' => ['required', 'url'],

            'order' => ['nullable', 'integer', 'min:0'],

            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Display a listing of social links.
     */
    public function index()
    {
        $socialLinks = SocialLink::ordered()->get();

        return view('admin.social_links.index', compact('socialLinks'));
    }

    /**
     * Show the form for creating a new social link.
     */
    public function create()
    {
        return view('admin.social_links.form', [
            'platforms' => SocialPlatform::cases(),
        ]);
    }

    /**
     * Store a newly created social link.
     */
    public function store(Request $request)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $socialLink = SocialLink::create($data);

            SystemLogger::log(
                'Social link created',
                'info',
                'social_links.store',
                [
                    'social_link_id' => $socialLink->id,
                    'platform' => $socialLink->platform->value,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('social-links.index')
                ->with('success', 'Social link created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Social link creation failed',
                'error',
                'social_links.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create social link.');
        }
    }

    /**
     * Show the form for editing the specified social link.
     */
    public function edit(SocialLink $socialLink)
    {
        return view('admin.social_links.form', [
            'socialLink' => $socialLink,
            'platforms' => SocialPlatform::cases(),
        ]);
    }

    /**
     * Update the specified social link.
     */
    public function update(Request $request, SocialLink $socialLink)
    {
        // ✅ Validation first
        $data = $this->validatedData($request, $socialLink);

        try {
            $socialLink->update($data);

            SystemLogger::log(
                'Social link updated',
                'info',
                'social_links.update',
                [
                    'social_link_id' => $socialLink->id,
                    'platform' => $socialLink->platform->value,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('social-links.index')
                ->with('success', 'Social link updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Social link update failed',
                'error',
                'social_links.update',
                [
                    'social_link_id' => $socialLink->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update social link.');
        }
    }

    /**
     * Remove the specified social link.
     */
    public function destroy(SocialLink $socialLink)
    {
        try {
            $socialLink->delete();

            SystemLogger::log(
                'Social link deleted',
                'warning',
                'social_links.delete',
                [
                    'social_link_id' => $socialLink->id,
                    'platform' => $socialLink->platform->value,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('social-links.index')
                ->with('success', 'Social link deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Social link deletion failed',
                'error',
                'social_links.delete',
                [
                    'social_link_id' => $socialLink->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete social link.');
        }
    }
}
