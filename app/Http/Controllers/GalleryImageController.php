<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use App\Helpers\S3;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\SystemLogger;
use Exception;

class GalleryImageController extends BaseController
{
  /**
   * Validation rules
   */
  public function index()
  {
    $images = GalleryImage::latest()->get();
    return view('admin.gallery-images.index', compact('images'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'images' => ['required', 'array'],
      'images.*' => ['image', 'max:5120'], // 5MB each
    ]);

    foreach ($request->file('images') as $file) {
      $path = S3::uploadImageAsWebp($file, 'gallery');

      GalleryImage::create([
        'image_url' => $path,
        'is_published' => true,
      ]);
    }

    return back()->with('success', 'Images uploaded successfully.');
  }

  public function destroy(GalleryImage $galleryImage)
  {
    if ($galleryImage->image_url) {
      S3::delete($galleryImage->image_url);
    }

    $galleryImage->delete();

    return back()->with('success', 'Image deleted.');
  }

}
