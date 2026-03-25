<?php

namespace App\Http\Controllers;

use App\Models\BookRecommendation;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use App\Helpers\S3;
use Exception;

class BookRecommendationController extends BaseController
{
  /**
   * Validation rules
   */
  protected function validateData(Request $request): array
  {
    return $request->validate([
      'title_en' => ['required', 'string', 'max:255'],
      'title_es' => ['nullable', 'string', 'max:255'],

      'description_en' => ['nullable', 'string'],
      'description_es' => ['nullable', 'string'],

      'image_url' => ['nullable', 'string'],
      'external_link' => ['nullable', 'url', 'max:255'],
    ]);
  }

  /**
   * Public: list all published blogs
   * URL: /our-blogs
   */
  public function indexPublic()
  {
    $books = BookRecommendation::all()
      ->sortByDesc('created_at');

    return view('frontend.book-recommendations.index', compact('books'));
  }

  /**
   * Display a listing of book recommendations.
   */
  public function index()
  {
    $books = BookRecommendation::orderByDesc('created_at')->get();

    return view('admin.book-recommendations.index', compact('books'));
  }

  /**
   * Show the form for creating a new recommendation.
   */
  public function create()
  {
    return view('admin.book-recommendations.form');
  }

  /**
   * Store a newly created recommendation.
   */
  public function store(Request $request)
  {
    $data = $this->validateData($request);

    try {
      $book = BookRecommendation::create($data);

      SystemLogger::log(
        'Book recommendation created',
        'info',
        'book-recommendations.store',
        [
          'book_id' => $book->id,
          'email' => $request->email,
        ]
      );

      return redirect()
        ->route('book-recommendations.index')
        ->with('success', 'Book recommendation created successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Book recommendation creation failed',
        'error',
        'book-recommendations.store',
        [
          'exception' => $e->getMessage(),
          'email' => $request->email,
        ]
      );

      return back()->withInput()->with('error', 'Failed to create book recommendation.');
    }
  }

  /**
   * Show the form for editing the recommendation.
   */
  public function edit(BookRecommendation $bookRecommendation)
  {
    return view('admin.book-recommendations.form', [
      'book' => $bookRecommendation,
    ]);
  }

  /**
   * Update the recommendation.
   */
  public function update(Request $request, BookRecommendation $bookRecommendation)
  {
    $data = $this->validateData($request);

    try {
      $bookRecommendation->update($data);

      SystemLogger::log(
        'Book recommendation updated',
        'info',
        'book-recommendations.update',
        [
          'book_id' => $bookRecommendation->id,
          'email' => $request->email,
        ]
      );

      return redirect()
        ->route('book-recommendations.index')
        ->with('success', 'Book recommendation updated successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Book recommendation update failed',
        'error',
        'book-recommendations.update',
        [
          'book_id' => $bookRecommendation->id,
          'exception' => $e->getMessage(),
          'email' => $request->email,
        ]
      );

      return back()->withInput()->with('error', 'Failed to update book recommendation.');
    }
  }

  /**
   * Remove the recommendation.
   */
  public function destroy(BookRecommendation $bookRecommendation)
  {
    try {
      // Cleanup image if exists
      if (!empty($bookRecommendation->image_url)) {
        S3::delete($bookRecommendation->image_url);
      }

      $bookRecommendation->delete();

      SystemLogger::log(
        'Book recommendation deleted',
        'warning',
        'book-recommendations.delete',
        [
          'book_id' => $bookRecommendation->id,
          'email' => request()->email,
        ]
      );

      return redirect()
        ->route('book-recommendations.index')
        ->with('success', 'Book recommendation deleted successfully.');

    } catch (Exception $e) {
      SystemLogger::log(
        'Book recommendation deletion failed',
        'error',
        'book-recommendations.delete',
        [
          'book_id' => $bookRecommendation->id,
          'exception' => $e->getMessage(),
          'email' => request()->email,
        ]
      );

      return back()->with('error', 'Failed to delete book recommendation.');
    }
  }
}
