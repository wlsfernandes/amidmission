<?php

namespace App\Http\Controllers;

use App\Helpers\S3;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FileUploadController extends BaseController
{
    /**
     * Allowed models for file uploads
     */
    protected array $models = [
        'events' => \App\Models\Event::class,
        'blogs' => \App\Models\Blog::class,
        'positions' => \App\Models\Position::class,
        'resources' => \App\Models\Resource::class,
    ];


    public function download(string $model, int $id, string $lang)
    {
        $instance = $this->resolveModel($model, $id);
        $column = $this->resolveColumn($lang);

        abort_if(!$instance->$column, 404);

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
            'Key' => $instance->$column,
        ]);

        $request = $client->createPresignedRequest($cmd, '+10 minutes');

        return redirect((string) $request->getUri());
    }

    protected array $languages = ['en', 'es'];

    public function edit(string $model, int $id, string $lang)
    {
        $instance = $this->resolveModel($model, $id);
        $column = $this->resolveColumn($lang);

        return view('admin.files.edit', [
            'modelKey' => $model,
            'model' => $instance,
            'lang' => $lang,
            'currentFile' => $instance->$column,
        ]);
    }

    public function update(Request $request, string $model, int $id, string $lang)
    {
        $instance = $this->resolveModel($model, $id);
        $column = $this->resolveColumn($lang);

        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        // Delete old file if exists
        if (!empty($instance->$column)) {
            S3::delete($instance->$column);
        }

        // Upload new file
        $path = S3::uploadFile(
            $request->file('file'),
            "{$model}/files/{$lang}"
        );

        $instance->update([
            $column => $path,
        ]);

        return redirect()
            ->route("{$model}.index")
            ->with('success', 'File uploaded successfully.');
    }


    /**
     * Resolve model safely
     */
    protected function resolveModel(string $model, int $id): Model
    {
        abort_unless(isset($this->models[$model]), 404);

        return $this->models[$model]::findOrFail($id);
    }

    /**
     * Resolve language column safely
     */
    protected function resolveColumn(string $lang): string
    {
        abort_unless(in_array($lang, $this->languages), 404);

        return "file_url_{$lang}";
    }
}
