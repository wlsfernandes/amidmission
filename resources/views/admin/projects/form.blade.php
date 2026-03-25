@extends('admin.layouts.master')

@section('title', isset($project) ? 'Edit Project' : 'Create Project')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-briefcase"></i>
                {{ isset($project) ? 'Edit Project' : 'Create Project' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper / Instructions --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How projects work:</span><br>
                • Projects are bilingual and public-facing.<br>
                • You may define a start and end date (optional).<br>
                • Projects can include multiple images (gallery).<br>
                • Use the <span class="text-success">Publish switch</span> to control visibility.
            </div>

            <hr>

            <form method="POST"
                action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}">
                @csrf
                @if (isset($project))
                    @method('PUT')
                @endif

                {{-- Publish --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $project->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this project on the website
                    </label>
                </div>
                {{-- Dates --}}
                <div class="row">
                    <div class="col-md-1 mb-2">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', isset($project->start_date) ? $project->start_date->format('Y-m-d') : '') }}">
                    </div>

                    <div class="col-md-1 mb-2">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ old('end_date', isset($project->end_date) ? $project->end_date->format('Y-m-d') : '') }}">
                    </div>
                    <div class="col-md-1 mb-2">
                        <label class="form-label">Order</label>
                        <input type="number" name="order" class="form-control" min="0"
                            value="{{ old('order', $collaborator->order ?? 0) }}">
                    </div>
                    <div class="col-md-8 mb-2">
                        <label class="form-label">External Link</label>
                        <input type="url" name="external_link" class="form-control" placeholder="https://example.com"
                            value="{{ old('external_link', $project->external_link ?? '') }}">

                    </div>

                </div>


                <hr>
                {{-- Title EN --}}
                <div class="mb-3">
                    <label class="form-label">Title (English)</label>
                    <input type="text" name="title_en" class="form-control"
                        value="{{ old('title_en', $project->title_en ?? '') }}" required>
                </div>

                {{-- Title ES --}}
                <div class="mb-3">
                    <label class="form-label">Title (Spanish)</label>
                    <input type="text" name="title_es" class="form-control"
                        value="{{ old('title_es', $project->title_es ?? '') }}" required>
                </div>

                <hr>

                {{-- Description EN --}}
                <div class="mb-3">
                    <label class="form-label">Description (English)</label>
                    <textarea class="form-control ckeditor" id="description_en" name="description_en" rows="4"
                        placeholder="Project description in English...">{{ old('description_en', $project->description_en ?? '') }}</textarea>
                </div>

                {{-- Description ES --}}
                <div class="mb-3">
                    <label class="form-label">Description (Spanish)</label>
                    <textarea class="form-control ckeditor" id="description_es" name="description_es" rows="4"
                        placeholder="Descripción del proyecto en español...">{{ old('description_es', $project->description_es ?? '') }}</textarea>
                </div>

                <hr>



                {{-- Gallery (only after create) --}}

                <hr>

                {{-- Actions --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($project) ? 'Update Project' : 'Create Project' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
