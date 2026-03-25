@extends('admin.layouts.master')

@section('title', isset($event) ? 'Edit Event' : 'Create Event')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-calendar-alt"></i>
                {{ isset($event) ? 'Edit Event' : 'Create Event' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to create or edit an event:</span><br>
                • Write the <span class="text-dark">English title</span> carefully — it is used to generate the public
                URL.<br>
                • Use the <span class="text-success">Publish switch</span> to control when the event is visible on the
                website.<br>
                • The <span class="text-warning">Event date</span> is when the event happens; publish dates only control
                visibility.<br>
                • Content supports <span class="text-info">basic formatting</span> (bold, lists, links).<br>
                • You can hide an event at any time without deleting it.
            </div>
            <hr />

            <form method="POST" action="{{ isset($event) ? route('events.update', $event) : route('events.store') }}">
                @csrf
                @if (isset($event))
                    @method('PUT')
                @endif
                {{-- =======================
                Dates (VERY CLEAR)
                ======================== --}}

                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $event->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this event on the website
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <input type="date" name="event_date" class="form-control"
                            value="{{ old('event_date', optional($event->event_date ?? null)->toDateString()) }}"
                            placeholder="Event date">
                        <small class="text-muted">
                            When the event actually happens.
                        </small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <input type="date" name="publish_start_at" class="form-control"
                            value="{{ old('publish_start_at', optional($event->publish_start_at ?? null)->toDateString()) }}"
                            placeholder="Publish start date">
                        <small class="text-muted">
                            Event becomes visible on the website.
                        </small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <input type="date" name="publish_end_at" class="form-control"
                            value="{{ old('publish_end_at', optional($event->publish_end_at ?? null)->toDateString()) }}"
                            placeholder="Publish end date">
                        <small class="text-muted">
                            Event is hidden after this date.
                        </small>
                    </div>
                </div>
                <hr>
                {{-- =======================
                Titles
                ======================== --}}
                <div class="mb-3">
                    <input type="text" name="title_en" class="form-control" placeholder="Create a title in English"
                        value="{{ old('title_en', $event->title_en ?? '') }}" required>
                    <small class="text-muted">
                        Used to generate the public URL (slug).
                    </small>
                </div>

                <div class="mb-3">
                    <input type="text" name="title_es" class="form-control" placeholder="Crear un título en español"
                        value="{{ old('title_es', $event->title_es ?? '') }}">
                    <small class="text-muted">
                        Optional Spanish version of the title.
                    </small>
                </div>


                <hr>

                {{-- =======================
                Content
                ======================== --}}
                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_en" name="content_en" rows="6"
                        placeholder="Write the event content in English...">{{ old('content_en', $event->content_en ?? '') }}</textarea>
                    <small class="text-muted">
                        This content will appear on the public event page.
                    </small>
                </div>

                <div class="mb-3">
                    <textarea class="form-control ckeditor" id="content_es" name="content_es" rows="6"
                        placeholder="Escriba el contenido del evento en español...">{{ old('content_es', $event->content_es ?? '') }}</textarea>
                    <small class="text-muted">
                        Contenido del evento en español.
                    </small>
                </div>
                <hr>


                <hr>
                <div class="mb-3">
                    <input type="url" name="external_link" class="form-control" placeholder="https://example.com"
                        value="{{ old('external_link', $event->external_link ?? '') }}">
                    <small class="text-muted">
                        Optional external page with more information or registration.
                    </small>
                </div>

                <hr>



                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($event) ? 'Update Event' : 'Create Event' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
