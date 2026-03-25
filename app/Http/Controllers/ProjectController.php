<?php
namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\Project;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;

class ProjectController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: before store/update)
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
     * Display the specified project.
     */
    public function display(string $slug)
    {
        $project = Project::visible()
            ->with('images') // eager load ordered images
            ->where('slug', $slug)
            ->firstOrFail();
        $bannerImage = $project->banner_url; // Get the first image URL for the banner
        return view('frontend.projects.display', compact('project', 'bannerImage'));
    }

    /**
     * Display a listing of projects.
     */
    public function index()
    {
        $projects = Project::orderByDesc('start_date')->get();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('admin.projects.form');
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        try {
            $project = Project::create($data);

            SystemLogger::log(
                'Project created',
                'info',
                'projects.store',
                [
                    'project_id' => $project->id,
                    'title_en'   => $project->title_en,
                    'email'      => $request->email,
                ]
            );

            return redirect()
                ->route('projects.index', $project)
                ->with('success', 'Project created successfully. You can now add images.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Project creation failed',
                'error',
                'projects.store',
                [
                    'exception' => $e->getMessage(),
                    'email'     => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create project.');
        }
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        $project->load('images');

        return view('admin.projects.form', compact('project'));
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, Project $project)
    {
        $data = $this->validatedData($request);

        try {
            $project->update($data);

            SystemLogger::log(
                'Project updated',
                'info',
                'projects.update',
                [
                    'project_id' => $project->id,
                    'email'      => $request->email,
                ]
            );

            return redirect()
                ->route('projects.index', $project)
                ->with('success', 'Project updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Project update failed',
                'error',
                'projects.update',
                [
                    'project_id' => $project->id,
                    'exception'  => $e->getMessage(),
                    'email'      => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update project.');
        }
    }

    /**
     * Remove the specified project.
     */
    public function destroy(Project $project)
    {
        try {
            // Load images before deleting project
            $project->load('images');

            // Delete all project images from S3
            foreach ($project->images as $image) {
                if (! empty($image->image_url)) {
                    S3::delete($image->image_url);
                }
            }

            // Delete project (will cascade delete project_images rows)
            $project->delete();

            SystemLogger::log(
                'Project deleted',
                'warning',
                'projects.delete',
                [
                    'project_id'     => $project->id,
                    'images_deleted' => $project->images->count(),
                    'email'          => request()->email,
                ]
            );

            return redirect()
                ->route('projects.index')
                ->with('success', 'Project deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Project deletion failed',
                'error',
                'projects.delete',
                [
                    'project_id' => $project->id,
                    'exception'  => $e->getMessage(),
                    'email'      => request()->email,
                ]
            );

            return back()->with('error', 'Failed to delete project.');
        }
    }

}
