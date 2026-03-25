<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use App\Services\SystemLogger;
use Aws\S3\S3Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ImageUploadController extends BaseController
{
    protected array $models = [
        'about' => \App\Models\About::class,
        'events' => \App\Models\Event::class,
        'blogs' => \App\Models\Blog::class,
        'banners' => \App\Models\Banner::class,
        'book-recommendations' => \App\Models\BookRecommendation::class,
        'donations' => \App\Models\Donation::class,
        'media-types' => \App\Models\MediaType::class,
        'gallery-images' => \App\Models\GalleryImage::class,
        'collaborators' => \App\Models\Collaborator::class,
        'collaborator-images' => \App\Models\CollaboratorImage::class,
        'partners' => \App\Models\Partner::class,
        'positions' => \App\Models\Position::class,
        'products' => \App\Models\Product::class,
        'projects' => \App\Models\Project::class,
        'project-images' => \App\Models\ProjectImage::class,
        'sections' => \App\Models\Section::class,
        'section_cards' => \App\Models\SectionCard::class,
        'section_images' => \App\Models\SectionImage::class,
        'settings' => \App\Models\Setting::class,
        'stores' => \App\Models\Store::class,
        'testimonials' => \App\Models\Testimonial::class,
        'teams' => \App\Models\Team::class,
        'pages' => \App\Models\Page::class,
        'resources' => \App\Models\Resource::class,
        'services' => \App\Models\Service::class,
        'settings' => \App\Models\Setting::class,

        // add more models here
    ];

    /**
     * Preview image from S3
     */
    public function preview(string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        abort_if(! $instance->image_url, 404);

        $client = new S3Client([
            'version' => 'latest',
            'region' => config('filesystems.disks.s3.region'),
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
        ]);

        $cmd = $client->getCommand('GetObject', [
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key' => $instance->image_url,
        ]);

        $request = $client->createPresignedRequest($cmd, '+10 minutes');

        return redirect((string) $request->getUri());
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

            DB::transaction(function () use ($request, $instance, $model, $preset) {

                // Delete old image if exists
                if (! empty($instance->image_url)) {
                    S3::delete($instance->image_url);
                }

                // Upload new image (WebP + correct size)
                $path = S3::uploadImageAsWebpPreset(
                    file: $request->file('image'),
                    directory: "{$model}/images",
                    mode: $preset['mode'],
                    width: $preset['width'],
                    height: $preset['height'],
                    quality: $preset['quality'],
                    disk: 's3'
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
                S3::delete($instance->image_url);

                $instance->update([
                    'image_url' => null,
                ]);
            }

            return back()->with('success', 'Image deleted successfully.');

        } catch (\Throwable $e) {

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
