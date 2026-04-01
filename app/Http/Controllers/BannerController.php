<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Banner;
use App\Models\Page;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Throwable;

class BannerController extends BaseController
{
    protected function validateData(Request $request): array
    {
        $request->merge([
            'is_published' => $request->has('is_published'),
            'open_in_new_tab' => $request->has('open_in_new_tab'),
        ]);

        return $request->validate([
            'page_id' => 'nullable|exists:pages,id',

            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'title_pt' => 'nullable|string|max:255',

            'subtitle_en' => 'nullable|string',
            'subtitle_es' => 'nullable|string',
            'subtitle_pt' => 'nullable|string',

            'link' => 'nullable|url|max:255',
            'open_in_new_tab' => 'nullable|boolean',

            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',

            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',

            'image_url' => 'nullable|image|max:2048',
        ]);
    }

    /**
     * List all banners (published + drafts).
     */
    public function index(Request $request)
    {
        $query = Banner::query();

        // Filter by page if provided
        if ($request->filled('page_id')) {
            $query->where('page_id', $request->page_id);
        }

        $banners = $query
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        // Optional: load page for context
        $page = null;

        if ($request->filled('page_id')) {
            $page = Page::find($request->page_id);
        }

        return view('admin.banners.index', compact('banners', 'page'));
    }

    /**
     * Show create form.
     */
    public function create(Request $request)
    {
        $pageId = $request->get('page_id');

        return view('admin.banners.form', compact('pageId'));
    }

    /**
     * Store new banners.
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);
        try {
            if ($request->hasFile('image_url')) {
                $data['image_url'] = S3::uploadImageAsWebpPreset(
                    $request->file('image_url'), // ✅ FIX HERE
                    'banners',
                    'cover',
                    1600,
                    600,
                    85
                );
            }
            Banner::create($data);

            return redirect()
                ->route('pages.index', $data['page_id'] ?? null)
                ->with('success', 'Banner created successfully.');

        } catch (Exception $e) {

            SystemLogger::log(
                'Banner creation failed',
                'error',
                'banners.store',
                [
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->withInput()->with('error', 'Failed to create banner.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(Banner $banner)
    {
        $pageId = $banner->page_id;

        return view('admin.banners.form', compact('banner', 'pageId'));
    }

    /**
     * Update banners.
     */
    public function update(Request $request, Banner $banner)
    {
        $data = $this->validateData($request);

        try {
            if ($request->hasFile('image_url')) {
                $data['image_url'] = S3::uploadImageAsWebpPreset(
                    $request->file('image_url'), // ✅ FIX HERE
                    'banners',
                    'cover',
                    1600,
                    600,
                    85
                );
            }
            $banner->update($data);

            return redirect()
                ->route('pages.index', $banner->page_id)
                ->with('success', 'Banner updated successfully.');

        } catch (Exception $e) {

            SystemLogger::log(
                'Banner update failed',
                'error',
                'banners.update',
                [
                    'banner_id' => $banner->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->withInput()->with('error', 'Failed to update banner.');
        }
    }

    /**
     * Delete banners.
     */
    public function destroy(Banner $banner)
    {
        try {
            // 🔥 Delete image from storage if exists
            if (! empty($banner->image_url)) {
                S3::delete($banner->image_url);
            }

            $banner->delete();

            SystemLogger::log(
                'Banner deleted',
                'info',
                'banners.delete',
                [
                    'banner_id' => $banner->id,
                    'title' => $banner->title_en,
                ]
            );

            return redirect()
                ->route('pages.index', $banner->page_id)
                ->with('success', 'Banner updated successfully.');

        } catch (Throwable $e) {
            SystemLogger::log(
                'Banner deletion failed',
                'error',
                'banners.delete',
                [
                    'banner_id' => $banner->id ?? null,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete banner.');
        }
    }
}
