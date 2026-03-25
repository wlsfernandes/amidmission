<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use App\Helpers\S3;
use Exception;

class PartnerController extends BaseController
{
    /**
     * Validation rules
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_url' => ['nullable', 'string'],
            'external_link' => ['nullable', 'url'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Display a listing of partners.
     */
    public function index()
    {
        $partners = Partner::orderByDesc('created_at')->get();

        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new partner.
     */
    public function create()
    {
        return view('admin.partners.form');
    }

    /**
     * Store a newly created partner.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        try {

            $partner = Partner::create($data);

            SystemLogger::log(
                'Partner created',
                'info',
                'partners.store',
                [
                    'partner_id' => $partner->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('partners.index')
                ->with('success', 'Partner created successfully.');
        } catch (Exception $e) {

            SystemLogger::log(
                'Partner creation failed',
                'error',
                'partners.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()->withInput()
                ->with('error', 'Failed to create partner.');
        }
    }

    /**
     * Show the form for editing the specified partner.
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.form', compact('partner'));
    }

    /**
     * Update the specified partner.
     */
    public function update(Request $request, Partner $partner)
    {
        $data = $this->validatedData($request);
        try {


            $partner->update($data);

            SystemLogger::log(
                'Partner updated',
                'info',
                'partners.update',
                [
                    'partner_id' => $partner->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('partners.index')
                ->with('success', 'Partner updated successfully.');
        } catch (Exception $e) {
            SystemLogger::log(
                'Partner update failed',
                'error',
                'partners.update',
                [
                    'partner_id' => $partner->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()->withInput()
                ->with('error', 'Failed to update partner.');
        }
    }

    /**
     * Remove the specified partner.
     */
    public function destroy(Partner $partner)
    {
        try {
            if (!empty($partner->image_url)) {
                S3::delete($partner->image_url);
            }

            $partner->delete();

            SystemLogger::log(
                'Partner deleted',
                'warning',
                'partners.delete',
                [
                    'partner_id' => $partner->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('partners.index')
                ->with('success', 'Partner deleted successfully.');
        } catch (Exception $e) {
            SystemLogger::log(
                'Partner deletion failed',
                'error',
                'partners.delete',
                [
                    'partner_id' => $partner->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()->with('error', 'Failed to delete partner.');
        }
    }
}
