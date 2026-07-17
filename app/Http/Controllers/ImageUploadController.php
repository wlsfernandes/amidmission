<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Models\About;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BookRecommendation;
use App\Models\Collaborator;
use App\Models\CollaboratorImage;
use App\Models\Donation;
use App\Models\Event;
use App\Models\GalleryImage;
use App\Models\MediaType;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Position;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Section;
use App\Models\SectionCard;
use App\Models\SectionImage;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Store;
use App\Models\Team;
use App\Models\Testimonial;
use App\Services\SystemLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImageUploadController extends BaseController
{
    protected array $models = [
        'about' => About::class,
        'events' => Event::class,
        'blogs' => Blog::class,
        'banners' => Banner::class,
        'book-recommendations' => BookRecommendation::class,
        'donations' => Donation::class,
        'media-types' => MediaType::class,
        'gallery-images' => GalleryImage::class,
        'collaborators' => Collaborator::class,
        'collaborator-images' => CollaboratorImage::class,
        'partners' => Partner::class,
        'positions' => Position::class,
        'products' => Product::class,
        'projects' => Project::class,
        'project-images' => ProjectImage::class,
        'sections' => Section::class,
        'section_cards' => SectionCard::class,
        'section_images' => SectionImage::class,
        'settings' => Setting::class,
        'stores' => Store::class,
        'testimonials' => Testimonial::class,
        'teams' => Team::class,
        'pages' => Page::class,
        'resources' => \App\Models\Resource::class,
        'services' => Service::class,
        'settings' => Setting::class,

        // add more models here
    ];

    /**
     * Preview an image using the configured filesystem disk.
     *
     * - local disk → streams the file with the correct MIME type.
     * - s3 disk    → redirects to a Laravel-generated temporary URL.
     */
    public function preview(string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        abort_if(! $instance->image_url, 404);

        $disk = config('filesystems.default', 'local');

        abort_unless(Storage::disk($disk)->exists($instance->image_url), 404);

        if ($disk === 's3') {
            return redirect(
                Storage::disk($disk)->temporaryUrl($instance->image_url, now()->addMinutes(10))
            );
        }

        // Local / public disk — stream the file securely.
        $mime = Storage::disk($disk)->mimeType($instance->image_url) ?: 'image/webp';

        return response(
            Storage::disk($disk)->get($instance->image_url),
            200,
            [
                'Content-Type' => $mime,
                'Cache-Control' => 'private, max-age=600',
            ]
        );
    }

    public function edit(string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        return view('admin.images.edit', [
            'modelKey' => $model,
            'model' => $instance,
            'image' => $instance->image_url,
        ]);
    }

    public function update(Request $request, string $model, int $id)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
            'image_type' => 'required|in:banner,blog_social,event_header,card,square,original_fit,logo',
        ]);

        try {
            $instance = $this->resolveModel($model, $id);

            $disk = config('filesystems.default', 'local');

            // Presets (simple + predictable)
            $preset = match ($request->input('image_type')) {
                'banner' => [
                    'mode' => 'cover', // crop to fit
                    'width' => 1920,
                    'height' => 600,
                    'quality' => 85,
                ],
                'blog_social' => [
                    'mode' => 'cover',
                    'width' => 1200,
                    'height' => 630,
                    'quality' => 85,
                ],
                'event_header' => [
                    'mode' => 'cover',
                    'width' => 1200,
                    'height' => 500,
                    'quality' => 85,
                ],
                'card' => [
                    'mode' => 'cover',
                    'width' => 900,
                    'height' => 600,
                    'quality' => 85,
                ],
                'square' => [
                    'mode' => 'cover',
                    'width' => 800,
                    'height' => 800,
                    'quality' => 85,
                ],
                'logo' => [
                    'mode' => 'cover',
                    'width' => 128,
                    'height' => 80,
                    'quality' => 95,
                ],
                default => [ // original_fit
                    'mode' => 'contain', // no crop (keeps full image)
                    'width' => 1600,
                    'height' => 1600,
                    'quality' => 85,
                ],
            };

            DB::transaction(function () use ($request, $instance, $model, $preset, $disk) {

                // Delete old image if exists
                if (! empty($instance->image_url)) {
                    S3::delete($instance->image_url, $disk);
                }

                // Upload new image (WebP + correct size)
                $path = S3::uploadImageAsWebpPreset(
                    file: $request->file('image'),
                    directory: "{$model}/images",
                    mode: $preset['mode'],
                    width: $preset['width'],
                    height: $preset['height'],
                    quality: $preset['quality'],
                    disk: $disk
                );

                $instance->update([
                    'image_url' => $path,
                ]);
            });
            if ($model === 'banners') {
                return redirect()
                    ->route('pages.index', $instance->page_id)
                    ->with('success', 'Image uploaded successfully.');
            }

            return redirect()
                ->route("{$model}.index")
                ->with('success', 'Image uploaded successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Image upload failed',
                'error',
                'images.update.failed',
                [
                    'model' => $model,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to upload image. Please try again.');
        }
    }

    protected function resolveModel(string $model, int $id): Model
    {
        abort_unless(isset($this->models[$model]), 404, "Model key [$model] not registered.");

        $class = $this->models[$model];

        Log::info('Model class resolved', [
            'class' => $class,
        ]);

        $record = $class::find($id);

        return $record ?? abort(404, "Record not found for $class with ID $id");
    }

    public function destroy(string $model, int $id)
    {
        try {
            $instance = $this->resolveModel($model, $id);

            if (! empty($instance->image_url)) {
                S3::delete($instance->image_url, config('filesystems.default', 'local'));

                $instance->update([
                    'image_url' => null,
                ]);
            }

            return back()->with('success', 'Image deleted successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Image deletion failed',
                'error',
                'images.delete.failed',
                [
                    'model' => $model,
                    'model_id' => $id,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete image.');
        }
    }
}
