<?php
namespace App\Helpers;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class S3
{
    /**
     * Upload ANY file (PDF, DOCX, ZIP, etc.)
     * Returns the stored path (NOT URL)
     */
    public static function uploadFile(
        UploadedFile $file,
        string $directory,
        string $disk = 's3'
    ): string {
        if (! $file->isValid()) {
            throw new Exception('Invalid file upload.');
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path     = trim($directory, '/') . '/' . $filename;

        Storage::disk($disk)->putFileAs(
            $directory,
            $file,
            $filename
        );

        return $path;
    }

    public static function uploadImageAsWebpPreset(
        UploadedFile $file,
        string $directory,
        string $mode = 'contain', // contain | cover
        int $width = 1600,
        int $height = 1600,
        int $quality = 85,
        string $disk = 's3'
    ): string {

        if (! $file || ! $file->isValid()) {
            throw new Exception('Invalid image upload.');
        }

        $realPath = $file->getRealPath();

        if (! $realPath || ! file_exists($realPath)) {
            throw new Exception('Uploaded file is not readable.');
        }

        if (! @exif_imagetype($realPath)) {
            throw new Exception('Uploaded file is not a valid image.');
        }

        $filename = Str::uuid() . '.webp';
        $path     = trim($directory, '/') . '/' . $filename;

        $manager = new ImageManager(new Driver());

        try {
            $img = $manager
                ->read($realPath)
                ->orient();

            // cover = exact size + crop overflow (best for banners/cards/square)
            if ($mode === 'cover') {
                $img = $img->cover($width, $height);
            } else {
                // contain = no crop (keeps whole image), scale down only
                // Note: scaleDown(width, height) is the right v3 approach
                $img = $img->scaleDown($width, $height);
            }

            $webp = $img->toWebp($quality);

        } catch (\Throwable $e) {
            throw new Exception('Unable to process image file.');
        }

        Storage::disk($disk)->put(
            $path,
            (string) $webp,
            [
                'ContentType' => 'image/webp',
                'Visibility'  => 'public',
            ]
        );

        return $path;
    }
    /**
     * Upload IMAGE and convert to WebP
     * Returns the stored path (NOT URL)
     */
    public static function uploadImageAsWebp(
        UploadedFile $file,
        string $directory,
        int $quality = 85,
        string $disk = 's3'
    ): string {

        if (! $file || ! $file->isValid()) {
            throw new Exception('Invalid image upload.');
        }

        $realPath = $file->getRealPath();

        if (! $realPath || ! file_exists($realPath)) {
            throw new Exception('Uploaded file is not readable.');
        }

        // Safer image validation (does not depend on filename)
        if (! @exif_imagetype($realPath)) {
            throw new Exception('Uploaded file is not a valid image.');
        }

        $filename = Str::uuid() . '.webp';
        $path     = trim($directory, '/') . '/' . $filename;

        $manager = new ImageManager(new Driver());

        try {
            $image = $manager
                ->read($realPath) // 🔥 use realPath instead of file object
                ->orient()
                ->resize(
                    1920,
                    1920,
                    function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }
                )
                ->toWebp($quality);

        } catch (\Throwable $e) {
            throw new Exception('Unable to process image file.');
        }

        Storage::disk($disk)->put(
            $path,
            (string) $image,
            [
                'ContentType' => 'image/webp',
                'Visibility'  => 'public',
            ]
        );

        return $path;
    }

    /**
     * Delete file from storage (by path)
     */
    public static function delete(
        ?string $path,
        string $disk = 's3'
    ): void {
        if (! $path) {
            return;
        }

        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
