<?php
namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Collaborator;
use App\Models\CollaboratorImage;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;

class CollaboratorImageController extends BaseController
{
    /**
     * Display the gallery for a collaborator.
     */
    public function index(Collaborator $collaborator)
    {
        $collaborator->load('images');

        return view('admin.collaborators.images.index', compact('collaborator'));
    }

    /**
     * Store a newly uploaded collaborator image.
     */
    public function store(Request $request, Collaborator $collaborator)
    {
        $request->validate([
            'image'         => ['required', 'image', 'max:5120'], // 5MB
            'external_link' => ['nullable', 'url', 'max:255'],
        ]);

        try {
            $path = S3::uploadImageAsWebp(
                $request->file('image'),
                'collaborators/images'
            );

            $position = $collaborator->images()->max('position') + 1;

            $image = $collaborator->images()->create([
                'image_url' => $path,
                'position'  => $position,
            ]);

            SystemLogger::log(
                'Collaborator image uploaded',
                'info',
                'collaborators.images.store',
                [
                    'collaborator_id' => $collaborator->id,
                    'image_id'        => $image->id,
                ]
            );

            return back()->with('success', 'Image uploaded successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Collaborator image upload failed',
                'error',
                'collaborators.images.store',
                [
                    'collaborator_id' => $collaborator->id,
                    'exception'       => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to upload image.');
        }
    }

    /**
     * Remove a project image.
     */
    public function destroy(Collaborator $collaborator, CollaboratorImage $image)
    {
        abort_unless($image->collaborator_id === $collaborator->id, 403);

        try {
            if ($image->image_url) {
                S3::delete($image->image_url);
            }

            $image->delete();

            SystemLogger::log(
                'Collaborator image deleted',
                'warning',
                'collaborators.images.delete',
                [
                    'collaborator_id' => $collaborator->id,
                    'image_id'        => $image->id,
                ]
            );

            return back()->with('success', 'Image deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Collaborator image deletion failed',
                'error',
                'collaborators.images.delete',
                [
                    'collaborator_id' => $collaborator->id,
                    'exception'       => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete image.');
        }
    }public function updateLink(Request $request, $collaboratorId, $imageId)
    {
        $request->validate([
            'external_link' => 'nullable|url',
        ]);

        try {
            $image = CollaboratorImage::findOrFail($imageId);

            $image->update([
                'external_link' => $request->external_link,
            ]);

            return back()->with('success', 'Link updated successfully.');

        } catch (\Throwable $e) {

            SystemLogger::log(
                'Image link update failed',
                'error',
                'collaborator.image.link.failed',
                [
                    'image_id'  => $imageId,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to update link.');
        }
    }

}
