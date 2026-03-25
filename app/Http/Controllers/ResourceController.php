<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use App\Helpers\S3;
use Exception;

class ResourceController extends BaseController
{
  /**
   * Validation rules
   * (Project standard: before store/update)
   */
  protected function validatedData(Request $request): array
  {
    return $request->validate([
      'title_en' => ['required', 'string', 'max:255'],
      'title_es' => ['nullable', 'string', 'max:255'],

      'description_en' => ['nullable', 'string'],
      'description_es' => ['nullable', 'string'],

      'file_url_en' => ['nullable', 'string'],
      'file_url_es' => ['nullable', 'string'],

      'external_link' => ['nullable', 'url'],

      'is_published' => ['nullable', 'boolean'],
    ]);
  }

  public function indexPublic()
  {
    $resources = Resource::visible()
      ->orderBy('title_en', 'asc')
      ->get();

    return view('frontend.resources.index', compact('resources'));
  }



  /**
   * Display a listing of resources.
   */
  public function index()
  {
    $resources = Resource::all();

    return view('admin.resources.index', compact('resources'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.resources.form');
  }

  /**
   * Store a newly created resource.
   */
  public function store(Request $request)
  {
    // ✅ Validation first
    $data = $this->validatedData($request);

    try {
      $resource = Resource::create($data);

      SystemLogger::log(
        'Resource created',
        'info',
        'resources.store',
        [
          'resource_id' => $resource->id,
          'email' => $request->email,
        ]
      );

      return redirect()
        ->route('resources.index')
        ->with('success', 'Resource created successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Resource creation failed',
        'error',
        'resources.store',
        [
          'exception' => $e->getMessage(),
          'email' => $request->email,
        ]
      );

      return back()
        ->withInput()
        ->with('error', 'Failed to create resource.');
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Resource $resource)
  {
    return view('admin.resources.form', compact('resource'));
  }

  /**
   * Update the specified resource.
   */
  public function update(Request $request, Resource $resource)
  {
    // ✅ Validation first
    $data = $this->validatedData($request);

    try {
      $resource->update($data);

      SystemLogger::log(
        'Resource updated',
        'info',
        'resources.update',
        [
          'resource_id' => $resource->id,
          'email' => $request->email,
        ]
      );

      return redirect()
        ->route('resources.index')
        ->with('success', 'Resource updated successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Resource update failed',
        'error',
        'resources.update',
        [
          'resource_id' => $resource->id,
          'exception' => $e->getMessage(),
          'email' => $request->email,
        ]
      );

      return back()
        ->withInput()
        ->with('error', 'Failed to update resource.');
    }
  }

  /**
   * Remove the specified resource.
   */
  public function destroy(Resource $resource)
  {
    try {
      // Cleanup associated files if exist
      if (!empty($resource->file_url_en)) {
        S3::delete($resource->file_url_en);
      }

      if (!empty($resource->file_url_es)) {
        S3::delete($resource->file_url_es);
      }

      $resource->delete();

      SystemLogger::log(
        'Resource deleted',
        'warning',
        'resources.delete',
        [
          'resource_id' => $resource->id,
          'email' => request()->email,
        ]
      );

      return redirect()
        ->route('resources.index')
        ->with('success', 'Resource deleted successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Resource deletion failed',
        'error',
        'resources.delete',
        [
          'resource_id' => $resource->id,
          'exception' => $e->getMessage(),
          'email' => request()->email,
        ]
      );

      return back()
        ->with('error', 'Failed to delete resource.');
    }
  }
}
