<?php
namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Collaborator;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;

class CollaboratorController extends BaseController
{
    /**
     * Validation rules
     * (Collaborator standard: before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title_en'       => ['required', 'string', 'max:255'],
            'title_es'       => ['required', 'string', 'max:255'],

            'description_en' => ['nullable', 'string'],
            'description_es' => ['nullable', 'string'],
            'external_link'  => ['nullable', 'url', 'max:255'],

            'start_date'     => ['nullable', 'date'],
            'end_date'       => ['nullable', 'date', 'after_or_equal:start_date'],

            'is_published'   => ['required', 'boolean'],
            'order'          => ['nullable', 'integer'],
        ]);
    }

    /**
     * Display the specified Collaborator.
     */
    public function display(string $slug)
    {
        $collaborator = Collaborator::visible()
            ->with('images')
            ->where('slug', $slug)
            ->firstOrFail();

        $bannerImage = $collaborator->banner_url;

        return view(
            'frontend.collaborators.display',
            compact('collaborator', 'bannerImage')
        );
    }

    /**
     * Display a listing of collaborators.
     */
    public function index()
    {
        $collaborators = Collaborator::orderByDesc('start_date')->get();

        return view('admin.collaborators.index', compact('collaborators'));
    }

    /**
     * Show the form for creating a new Collaborator.
     */
    public function create()
    {
        return view('admin.collaborators.form');
    }

    /**
     * Store a newly created Collaborator.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        try {
            $collaborator = Collaborator::create($data);

            SystemLogger::log(
                'Collaborator created',
                'info',
                'collaborators.store',
                [
                    'collaborator_id' => $collaborator->id,
                    'title_en'        => $collaborator->title_en,
                    'email'           => $request->email,
                ]
            );

            return redirect()
                ->route('collaborators.index', $collaborator)
                ->with('success', 'Collaborator created successfully. You can now add images.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Collaborator creation failed',
                'error',
                'collaborators.store',
                [
                    'exception' => $e->getMessage(),
                    'email'     => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create Collaborator.');
        }
    }

    /**
     * Show the form for editing the specified Collaborator.
     */
    public function edit(Collaborator $collaborator)
    {
        $collaborator->load('images');

        return view('admin.collaborators.form', compact('collaborator'));
    }

    /**
     * Update the specified Collaborator.
     */
    public function update(Request $request, Collaborator $collaborator)
    {
        $data = $this->validatedData($request);

        try {
            $collaborator->update($data);

            SystemLogger::log(
                'Collaborator updated',
                'info',
                'collaborators.update',
                [
                    'collaborator_id' => $collaborator->id,
                    'email'           => $request->email,
                ]
            );

            return redirect()
                ->route('collaborators.index', $collaborator)
                ->with('success', 'Collaborator updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Collaborator update failed',
                'error',
                'collaborators.update',
                [
                    'collaborator_id' => $collaborator->id,
                    'exception'       => $e->getMessage(),
                    'email'           => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update Collaborator.');
        }
    }

    /**
     * Remove the specified Collaborator.
     */
    public function destroy(Collaborator $collaborator)
    {
        try {
            // Load images before deleting Collaborator
            $collaborator->load('images');

            // Delete all Collaborator images from S3
            foreach ($collaborator->images as $image) {
                if (! empty($image->image_url)) {
                    S3::delete($image->image_url);
                }
            }

            // Delete Collaborator (will cascade delete collaborators_images rows)
            $collaborator->delete();

            SystemLogger::log(
                'Collaborator deleted',
                'warning',
                'collaborators.delete',
                [
                    'collaborator_id' => $collaborator->id,
                    'images_deleted'  => $collaborator->images->count(),
                    'email'           => request()->email,
                ]
            );

            return redirect()
                ->route('collaborators.index')
                ->with('success', 'Collaborator deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Collaborator deletion failed',
                'error',
                'collaborators.delete',
                [
                    'collaborator_id' => $collaborator->id,
                    'exception'       => $e->getMessage(),
                    'email'           => request()->email,
                ]
            );

            return back()->with('error', 'Failed to delete Collaborator.');
        }
    }

}
