<?php

namespace App\Helpers;

use App\Models\Media;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class S3
{
    protected static function baseFolder(): string
    {
        return trim((string) env('APP_FOLDER', config('app.name', 'application')), '/');
    }

    protected static function buildPath(string $directory): string
    {
        $base = self::baseFolder();

        return trim($base.'/'.trim($directory, '/'), '/');
    }

    protected static function storeMedia(
        string $path,
        string $directory,
        UploadedFile $file,
        string $disk = 's3'
    ): void {
        try {
            Media::firstOrCreate(
                ['path' => $path],
                [
                    'disk' => $disk,
                    'folder' => $directory,
                    'filename' => basename($path),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]
            );
        } catch (\Throwable $e) {
            // 🔕 silent fail — NEVER break upload because of media table
        }
    }

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

        $directory = self::buildPath($directory);

        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $path = $directory.'/'.$filename;

        Storage::disk($disk)->putFileAs(
            $directory,
            $file,
            $filename
        );

        // ✅ Save media
        self::storeMedia($path, $directory, $file, $disk);

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

        // ✅ APPLY APP FOLDER AUTOMATICALLY
        $baseFolder = trim((string) env('APP_FOLDER', config('app.name', 'application')), '/');
        $directory = trim($baseFolder.'/'.trim($directory, '/'), '/');

        $filename = Str::uuid().'.webp';
        $path = $directory.'/'.$filename;

        $manager = new ImageManager(new Driver);

        try {
            $img = $manager
                ->read($realPath)
                ->orient();

            if ($mode === 'cover') {
                $img = $img->cover($width, $height);
            } else {
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
                'Visibility' => 'public',
            ]
        );

        // ✅ SAVE TO MEDIA TABLE (SAFE - WILL NOT BREAK UPLOAD)
        try {
            \App\Models\Media::firstOrCreate(
                ['path' => $path],
                [
                    'disk' => $disk,
                    'folder' => $directory,
                    'filename' => basename($path),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]
            );
        } catch (\Throwable $e) {
            // 🔕 Do nothing — never break upload because of media logging
        }

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

        if (! @exif_imagetype($realPath)) {
            throw new Exception('Uploaded file is not a valid image.');
        }

        // ✅ APPLY APP FOLDER
        $baseFolder = trim((string) env('APP_FOLDER', config('app.name', 'application')), '/');
        $directory = trim($baseFolder.'/'.trim($directory, '/'), '/');

        $filename = Str::uuid().'.webp';
        $path = $directory.'/'.$filename;

        $manager = new ImageManager(new Driver);

        try {
            $image = $manager
                ->read($realPath)
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
                'Visibility' => 'public',
            ]
        );

        // ✅ SAVE TO MEDIA (SAFE)
        try {
            Media::firstOrCreate(
                ['path' => $path],
                [
                    'disk' => $disk,
                    'folder' => $directory,
                    'filename' => basename($path),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]
            );
        } catch (\Throwable $e) {
            // never break upload
        }

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

        try {
            // 🔹 Delete from storage if exists
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }

            // 🔹 Remove from media table
            Media::where('path', $path)->delete();

        } catch (\Throwable $e) {
            // 🔕 Do not throw — avoid breaking system
        }
    }
}
