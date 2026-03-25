<?php

namespace App\Http\Controllers;

use App\Models\Wikipedia;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WikipediaController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: keep before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Display a listing of wikipedias.
     */
    public function index()
    {
        $wikipedias = Wikipedia::all();

        return view('admin.wikipedias.index', compact('wikipedias'));
    }

    /**
     * Show the form for creating a new wikipedia entry.
     */
    public function create()
    {
        return view('admin.wikipedias.form');
    }

    /**
     * Show the form for editing an existing Wikipedia entry.
     */
    public function show(string $id)
    {
        $wikipedia = Wikipedia::findOrFail($id);

        return view('admin.wikipedias.form', compact('wikipedia'));
    }

    /**
     * Store a newly created wikipedia entry.
     */
    public function store(Request $request)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);
        $data['created_by'] = Auth::user()->email;
        try {
            $wikipedia = Wikipedia::create($data);

            SystemLogger::log(
                'Wikipedia entry created',
                'info',
                'wikipedias.store',
                [
                    'wikipedia_id' => $wikipedia->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('wikipedias.index')
                ->with('success', 'Wikipedia entry created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Wikipedia entry creation failed',
                'error',
                'wikipedias.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create Wikipedia entry.');
        }
    }

    /**
     * Show the form for editing the specified wikipedia entry.
     */
    public function edit(Wikipedia $wikipedia)
    {
        return view('admin.wikipedias.form', compact('wikipedia'));
    }

    /**
     * Update the specified wikipedia entry.
     */
    public function update(Request $request, Wikipedia $wikipedia)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);
        $data['updated_by'] = Auth::user()->email;
        try {
            $wikipedia->update($data);

            SystemLogger::log(
                'Wikipedia entry updated',
                'info',
                'wikipedias.update',
                [
                    'wikipedia_id' => $wikipedia->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('wikipedias.index')
                ->with('success', 'Wikipedia entry updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Wikipedia entry update failed',
                'error',
                'wikipedias.update',
                [
                    'wikipedia_id' => $wikipedia->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update Wikipedia entry.');
        }
    }

    /**
     * Remove the specified wikipedia entry.
     */
    public function destroy(Wikipedia $wikipedia)
    {
        try {
            $wikipedia->delete();

            SystemLogger::log(
                'Wikipedia entry deleted',
                'warning',
                'wikipedias.delete',
                [
                    'wikipedia_id' => $wikipedia->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('wikipedias.index')
                ->with('success', 'Wikipedia entry deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Wikipedia entry deletion failed',
                'error',
                'wikipedias.delete',
                [
                    'wikipedia_id' => $wikipedia->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete Wikipedia entry.');
        }
    }
}
