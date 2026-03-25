<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use App\Helpers\S3;
use App\Services\SystemLogger;
use Exception;

class ProjectImageController extends BaseController
{
  /**
   * Display the gallery for a project.
   */
  public function index(Project $project)
  {
    $project->load('images');

    return view('admin.projects.images.index', compact('project'));
  }

  /**
   * Store a newly uploaded project image.
   */
  public function store(Request $request, Project $project)
  {
    $request->validate([
      'image' => ['required', 'image', 'max:5120'], // 5MB
    ]);

    try {
      $path = S3::uploadImageAsWebp(
        $request->file('image'),
        'projects/images'
      );

      $position = $project->images()->max('position') + 1;

      $image = $project->images()->create([
        'image_url' => $path,
        'position' => $position,
      ]);

      SystemLogger::log(
        'Project image uploaded',
        'info',
        'projects.images.store',
        [
          'project_id' => $project->id,
          'image_id' => $image->id,
        ]
      );

      return back()->with('success', 'Image uploaded successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Project image upload failed',
        'error',
        'projects.images.store',
        [
          'project_id' => $project->id,
          'exception' => $e->getMessage(),
        ]
      );

      return back()->with('error', 'Failed to upload image.');
    }
  }

  /**
   * Remove a project image.
   */
  public function destroy(Project $project, ProjectImage $image)
  {
    abort_unless($image->project_id === $project->id, 403);

    try {
      if ($image->image_url) {
        S3::delete($image->image_url);
      }

      $image->delete();

      SystemLogger::log(
        'Project image deleted',
        'warning',
        'projects.images.delete',
        [
          'project_id' => $project->id,
          'image_id' => $image->id,
        ]
      );

      return back()->with('success', 'Image deleted successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Project image deletion failed',
        'error',
        'projects.images.delete',
        [
          'project_id' => $project->id,
          'exception' => $e->getMessage(),
        ]
      );

      return back()->with('error', 'Failed to delete image.');
    }
  }
}
