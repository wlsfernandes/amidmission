<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Page;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    /**
     * Display a public page by slug.
     */

    /**
     * Validation rules
     * (Project standard: before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_es' => ['nullable', 'string', 'max:255'],
            'title_pt' => ['nullable', 'string', 'max:255'],

            'image_url' => ['nullable', 'string'],

            'content_en' => ['nullable', 'string'],
            'content_es' => ['nullable', 'string'],
            'content_pt' => ['nullable', 'string'],

            'is_published' => ['nullable', 'boolean'],
            // ✅ SEO Core
            'seo_title_en' => ['nullable', 'string', 'max:255'],
            'seo_title_es' => ['nullable', 'string', 'max:255'],
            'seo_title_pt' => ['nullable', 'string', 'max:255'],
            'seo_description_en' => ['nullable', 'string'],
            'seo_description_es' => ['nullable', 'string'],
            'seo_description_pt' => ['nullable', 'string'],
            'seo_keywords' => ['nullable', 'string'], // Could be JSON or comma-separated
            // ✅ Social / Open Graph
            'og_title_en' => ['nullable', 'string', 'max:255'],
            'og_title_es' => ['nullable', 'string', 'max:255'],
            'og_title_pt' => ['nullable', 'string', 'max:255'],
            'og_description_en' => ['nullable', 'string'],
            'og_description_es' => ['nullable', 'string'],
            'og_image_url' => ['nullable', 'string'],
            // ✅ Indexing control
            'no_index' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Display a listing of pages.
     */
    public function index()
    {
        $pages = Page::withCount(['sections', 'banners'])->get();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        return view('admin.pages.form');
    }

    /**
     * Store a newly created page.
     */
    public function store(Request $request)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $page = Page::create($data);

            SystemLogger::log(
                'Page created',
                'info',
                'pages.store',
                [
                    'page_id' => $page->id,
                    'slug' => $page->slug,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('pages.index')
                ->with('success', 'Page created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Page creation failed',
                'error',
                'pages.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create page.');
        }
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    /**
     * Update the specified page.
     */
    public function update(Request $request, Page $page)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $page->update($data);

            SystemLogger::log(
                'Page updated',
                'info',
                'pages.update',
                [
                    'page_id' => $page->id,
                    'slug' => $page->slug,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('pages.index')
                ->with('success', 'Page updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Page update failed',
                'error',
                'pages.update',
                [
                    'page_id' => $page->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update page.');
        }
    }

    /**
     * Remove the specified page.
     */
    public function destroy(Page $page)
    {
        try {
            // Cleanup banner image if exists
            if (! empty($page->image_url)) {
                S3::delete($page->image_url);
            }

            $page->delete();

            SystemLogger::log(
                'Page deleted',
                'warning',
                'pages.delete',
                [
                    'page_id' => $page->id,
                    'slug' => $page->slug,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('pages.index')
                ->with('success', 'Page deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Page deletion failed',
                'error',
                'pages.delete',
                [
                    'page_id' => $page->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete page.');
        }
    }
}
