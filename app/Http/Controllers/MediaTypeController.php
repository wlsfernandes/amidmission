<?php

namespace App\Http\Controllers;

use App\Models\MediaType;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use Exception;

class MediaTypeController extends BaseController
{
  /**
   * Validation rules
   * (Project standard: before store/update)
   */
  protected function validatedData(Request $request, ?MediaType $mediaType = null): array
  {
    return $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'description_en' => ['nullable', 'string'],
      'description_es' => ['nullable', 'string'],
      'is_active' => ['required', 'boolean'],
    ]);
  }

  /**
   * Display a listing of media types.
   */
  public function index()
  {
    $mediaTypes = MediaType::orderBy('name')->get();

    return view('admin.media-types.index', compact('mediaTypes'));
  }

  /**
   * Show the form for creating a new media type.
   */
  public function create()
  {
    return view('admin.media-types.form');
  }

  /**
   * Store a newly created media type.
   */
  public function store(Request $request)
  {
    $data = $this->validatedData($request);

    try {
      $mediaType = MediaType::create($data);

      SystemLogger::log(
        'Media type created',
        'info',
        'media_types.store',
        [
          'media_type_id' => $mediaType->id,
          'name' => $mediaType->name,
          'email' => $request->email,
        ]
      );

      return redirect()
        ->route('media-types.index')
        ->with('success', 'Media type created successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Media type creation failed',
        'error',
        'media_types.store',
        [
          'exception' => $e->getMessage(),
          'email' => $request->email,
        ]
      );

      return back()
        ->withInput()
        ->with('error', 'Failed to create media type.');
    }
  }

  /**
   * Show the form for editing the specified media type.
   */
  public function edit(MediaType $mediaType)
  {
    return view('admin.media-types.form', compact('mediaType'));
  }

  /**
   * Update the specified media type.
   */
  public function update(Request $request, MediaType $mediaType)
  {
    $data = $this->validatedData($request, $mediaType);

    try {
      $mediaType->update($data);

      SystemLogger::log(
        'Media type updated',
        'info',
        'media_types.update',
        [
          'media_type_id' => $mediaType->id,
          'name' => $mediaType->name,
          'email' => $request->email,
        ]
      );

      return redirect()
        ->route('media-types.index')
        ->with('success', 'Media type updated successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Media type update failed',
        'error',
        'media_types.update',
        [
          'media_type_id' => $mediaType->id,
          'exception' => $e->getMessage(),
          'email' => $request->email,
        ]
      );

      return back()
        ->withInput()
        ->with('error', 'Failed to update media type.');
    }
  }

  /**
   * Remove the specified media type.
   */
  public function destroy(MediaType $mediaType)
  {
    try {
      $mediaType->delete();

      SystemLogger::log(
        'Media type deleted',
        'warning',
        'media_types.delete',
        [
          'media_type_id' => $mediaType->id,
          'name' => $mediaType->name,
          'email' => request()->email,
        ]
      );

      return redirect()
        ->route('media-types.index')
        ->with('success', 'Media type deleted successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Media type deletion failed',
        'error',
        'media_types.delete',
        [
          'media_type_id' => $mediaType->id,
          'exception' => $e->getMessage(),
          'email' => request()->email,
        ]
      );

      return back()
        ->with('error', 'Failed to delete media type.');
    }
  }
}
