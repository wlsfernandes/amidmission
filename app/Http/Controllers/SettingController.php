<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use Exception;

class SettingController extends BaseController
{
    /**
     * Admin entry point.
     * Redirects to the singleton edit screen.
     */
    public function index()
    {
        return redirect()->route('settings.edit');
    }

    /**
     * Show the settings form (singleton).
     */
    public function edit()
    {
        $setting = Setting::current();

        return view('admin.settings.form', compact('setting'));
    }

    /**
     * Update the site settings.
     */
    public function update(Request $request)
    {
        // ✅ Validation FIRST
        $data = $this->validatedData($request);

        $setting = Setting::current();

        try {
            $setting->update($data);

            SystemLogger::log(
                'Settings updated',
                'info',
                'settings.update',
                [
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('settings.edit')
                ->with('success', 'Settings updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Settings update failed',
                'error',
                'settings.update',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update settings.');
        }
    }

    /**
     * Validation rules
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            // Site identity
            'site_name' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string'],      // logo
            'favicon_url' => ['nullable', 'string'],

            // Contact info
            'contact_email' => ['nullable', 'email'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],

            // Footer
            'footer_text' => ['nullable', 'string'],

            // Default SEO
            'default_seo_title' => ['nullable', 'string', 'max:255'],
            'default_seo_description' => ['nullable', 'string'],
        ]);
    }
}
