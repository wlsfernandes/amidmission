<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Page;
use App\Models\Section;
use App\Models\SectionImage;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends BaseController
{
    /**
     * Validation rules
     */
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'sort_order' => ['nullable', 'integer'],
            'feature_type' => 'nullable|string|in:team,partners,testimonial,services,blog,donate,event,contact',
            'title_en' => ['nullable', 'string', 'max:255'],
            'title_es' => ['nullable', 'string', 'max:255'],
            'title_pt' => ['nullable', 'string', 'max:255'],
            'content_en' => ['nullable', 'string'],
            'content_es' => ['nullable', 'string'],
            'content_pt' => ['nullable', 'string'],
            'is_published' => ['nullable', 'boolean'],
            'external_link' => ['nullable', 'url', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'image' => 'nullable|image|max:2048',
            'type' => ['nullable', 'string'],
            'layout' => ['nullable', 'string'],
            'button_position' => ['nullable', 'string'],
            'button_color' => ['nullable', 'string'],
            'link_image' => 'nullable|string|max:255',
        ]);
    }

    /**
     * List sections for a page
     */
    public function index(Page $page): View
    {
        $sections = $page->sections()
            ->orderBy('sort_order')
            ->get();

        return view('admin.pages.sections.index', compact('page', 'sections'));
    }

    /**
     * Create section form
     */
    public function create(Page $page): View
    {
        return view('admin.pages.sections.form', compact('page'));
    }

    /**
     * Store new section
     */
    public function store(Request $request, Page $page): RedirectResponse
    {
        $data = $this->validateData($request);
        try {

            $data['page_id'] = $page->id;

            $section = Section::create($data);
            // Upload image if provided
            $this->handleImageUpload($request, $section, $data);
            if (! empty($data['image_url'])) {
                $section->update(['image_url' => $data['image_url']]);
            }

            SystemLogger::log(
                'Page section created',
                'info',
                'page_sections.create',
                [
                    'page_id' => $page->id,
                    'section_id' => $section->id,
                ]
            );

            return redirect()
                ->route('pages.sections.index', ['page' => $page])
                ->with('success', 'Section created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Page section creation failed',
                'error',
                'page_sections.create',
                [
                    'page_id' => $page->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->withInput()->with('error', 'Failed to create section.');
        }
    }

    /**
     * Edit section form
     */
    public function edit(Page $page, Section $section)
    {
        return view('admin.pages.sections.form', [
            'page' => $page,
            'section' => $section,
        ]);
    }

    /**
     * Update section
     */
    public function update(Request $request, Page $page, Section $section): RedirectResponse
    {
        $data = $this->validateData($request);

        try {

            /*
            |--------------------------------------------------------------------------
            | Handle sort order changes
            |--------------------------------------------------------------------------
            */

            if (isset($data['sort_order']) && $data['sort_order'] != $section->sort_order) {

                Section::where('page_id', $page->id)
                    ->where('id', '!=', $section->id)
                    ->where('sort_order', '>=', $data['sort_order'])
                    ->increment('sort_order');
            }

            /*
            |--------------------------------------------------------------------------
            | Image upload
            |--------------------------------------------------------------------------
            */

            // Upload image if provided
            $this->handleImageUpload($request, $section, $data);
            if (! empty($data['image_url'])) {
                $section->update(['image_url' => $data['image_url']]);
            }

            /*
            |--------------------------------------------------------------------------
            | Update section
            |--------------------------------------------------------------------------
            */

            $section->update($data);

            SystemLogger::log(
                'Page section updated',
                'info',
                'page_sections.update',
                [
                    'page_id' => $page->id,
                    'section_id' => $section->id,
                ]
            );

            return redirect()
                ->route('pages.sections.index', ['page' => $page])
                ->with('success', 'Section updated successfully.');

        } catch (Exception $e) {

            SystemLogger::log(
                'Page section update failed',
                'error',
                'page_sections.update',
                [
                    'page_id' => $page->id,
                    'section_id' => $section->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->withInput()->with('error', 'Failed to update section.');
        }

    }

    /**
     * Delete section
     */
    public function destroy(Page $page, Section $section): RedirectResponse
    {
        try {
            $section->delete();

            SystemLogger::log(
                'Page section deleted',
                'warning',
                'page_sections.delete',
                [
                    'page_id' => $page->id,
                    'section_id' => $section->id,
                ]
            );

            return redirect()
                ->route('pages.sections.index', ['page' => $page])
                ->with('success', 'Section deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Page section deletion failed',
                'error',
                'page_sections.delete',
                [
                    'page_id' => $page->id,
                    'section_id' => $section->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete section.');
        }
    }

    public function destroyImage(Page $page, Section $section, SectionImage $image)
    {

        try {
            // delete image from section->image
            if ($section->image_url) {
                S3::delete($section->image_url);

                $section->update([
                    'image_url' => null,
                ]);
            }

            // delete multiple images from section_images
            if ($image->image_url) {
                S3::delete($image->image_url);
            }

            $image->delete();

            SystemLogger::log(
                'Section image deleted',
                'warning',
                'section_images.delete',
                [
                    'page_id' => $page->id,
                    'section_id' => $section->id,
                    'image_id' => $image->id,
                ]
            );

            return response()->json([
                'success' => true,
            ]);

        } catch (Exception $e) {

            SystemLogger::log(
                'Section image deletion failed',
                'error',
                'section_images.delete',
                [
                    'page_id' => $page->id,
                    'section_id' => $section->id,
                    'image_id' => $image->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
            ], 500);
        }
    }

    public function destroySectionImage(Page $page, Section $section)
    {
        try {

            if ($section->image_url) {
                S3::delete($section->image_url);
            }

            $section->update([
                'image_url' => null,
            ]);

            return response()->json([
                'success' => true,
            ]);

        } catch (\Exception $e) {

            SystemLogger::log(
                'Section single image deletion failed',
                'error',
                'section.image.delete',
                [
                    'page_id' => $page->id,
                    'section_id' => $section->id,
                    'exception' => $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
            ], 500);
        }
    }

    private function handleImageUpload(Request $request, Section $section, array &$data): void
    {
        if ($request->hasFile('image_url') && ! is_array($request->file('image_url'))) {

            $data['image_url'] = S3::uploadImageAsWebpPreset(
                $request->file('image_url'),
                'pages/sections'
            );
        }

        if ($request->hasFile('gallery_images')) {

            foreach ($request->file('gallery_images') as $image) {

                $path = S3::uploadImageAsWebpPreset(
                    $image,
                    'pages/sections/gallery'
                );

                $section->images()->create([
                    'image_url' => $path,
                    'external_link' => $request->input('external_link'),
                    'sort_order' => ($section->images()->max('sort_order') ?? 0) + 1,
                ]);
            }
        }
    }
}
