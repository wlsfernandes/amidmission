<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Services\SystemLogger;

class PublishController extends BaseController
{
    public function toggle(Request $request, string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        $column = $request->get('column', 'is_published');

        if (!isset($instance->{$column})) {
            abort(400, "Publish column '{$column}' does not exist.");
        }

        $instance->update([
            $column => !(bool) $instance->{$column},
        ]);

        SystemLogger::log(
            class_basename($instance) . ' publish toggled',
            'info',
            Str::snake(class_basename($instance)) . '.publish.toggle',
            [
                'id' => $instance->id,
                'column' => $column,
                'published' => $instance->{$column},
                'email' => auth()->user()?->email,
                'roles' => auth()->user()?->roles?->pluck('name')->toArray() ?? [],
            ]
        );

        return $this->redirectToIndex($model)
            ->with('success', 'Publish status updated successfully.');
    }

    protected function resolveModel(string $model, int $id)
    {
        $class = 'App\\Models\\' . Str::studly(Str::singular($model));

        if (!class_exists($class)) {
            throw new NotFoundHttpException("Model '{$model}' not found.");
        }

        return $class::findOrFail($id);
    }

    protected function redirectToIndex(string $model)
    {
        /**
         * IMPORTANT:
         * Resource route names are NOT always the same as model names.
         * Example:
         *   model: about_us
         *   route: about.index
         */

        $resource = Str::replaceLast('_us', '', $model); // about_us → about
        $route = "{$resource}.index";

        return Route::has($route)
            ? redirect()->route($route)
            : redirect()->back();
    }
}
