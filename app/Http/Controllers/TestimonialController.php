<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use App\Helpers\S3;
use Exception;

class TestimonialController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: keep before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],

            'content_en' => ['required', 'string'],
            'content_es' => ['nullable', 'string'],

            'image_url' => ['nullable', 'string'],

            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Display a listing of testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::all();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        return view('admin.testimonials.form');
    }

    /**
     * Store a newly created testimonial.
     */
    public function store(Request $request)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $testimonial = Testimonial::create($data);

            SystemLogger::log(
                'Testimonial created',
                'info',
                'testimonials.store',
                [
                    'testimonial_id' => $testimonial->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('testimonials.index')
                ->with('success', 'Testimonial created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Testimonial creation failed',
                'error',
                'testimonials.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create testimonial.');
        }
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    /**
     * Update the specified testimonial.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $testimonial->update($data);

            SystemLogger::log(
                'Testimonial updated',
                'info',
                'testimonials.update',
                [
                    'testimonial_id' => $testimonial->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('testimonials.index')
                ->with('success', 'Testimonial updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Testimonial update failed',
                'error',
                'testimonials.update',
                [
                    'testimonial_id' => $testimonial->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update testimonial.');
        }
    }

    /**
     * Remove the specified testimonial.
     */
    public function destroy(Testimonial $testimonial)
    {
        try {
            // Cleanup associated image
            if (!empty($testimonial->image_url)) {
                S3::delete($testimonial->image_url);
            }

            $testimonial->delete();

            SystemLogger::log(
                'Testimonial deleted',
                'warning',
                'testimonials.delete',
                [
                    'testimonial_id' => $testimonial->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('testimonials.index')
                ->with('success', 'Testimonial deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Testimonial deletion failed',
                'error',
                'testimonials.delete',
                [
                    'testimonial_id' => $testimonial->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete testimonial.');
        }
    }
}
