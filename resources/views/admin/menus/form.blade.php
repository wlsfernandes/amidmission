@extends('admin.layouts.master')

@section('title', isset($menu->id) ? 'Edit Menu Item' : 'Create Menu Item')

@section('content')

    <div class="card border border-primary">

        <div class="card-header">
            <h5 class="mb-0">
                <i class="uil uil-bars"></i>
                {{ isset($menu->id) ? 'Edit Menu Item' : 'Create Menu Item' }}
            </h5>
        </div>

        <div class="card-body">

            <x-alert />

            <form method="POST" action="{{ isset($menu->id) ? route('menus.update', $menu) : route('menus.store') }}">

                @csrf

                @if (isset($menu->id))
                    @method('PUT')
                @endif

                <div class="row">

                    {{-- Title EN --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Title (English) <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="title_en" class="form-control"
                            value="{{ old('title_en', $menu->title_en) }}" required>
                        <p class="text-muted small mt-1">
                            This is the main label shown in the website menu (English version).
                            Keep it short and clear (1–3 words recommended).
                            Example: "About", "Programs", "Contact".
                        </p>
                    </div>


                    {{-- Title ES --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Title (Spanish)
                        </label>

                        <input type="text" name="title_es" class="form-control"
                            value="{{ old('title_es', $menu->title_es) }}">
                        <p class="text-muted small mt-1">
                            This is the main label shown in the website menu (Spanish version).
                            Keep it short and clear (1–3 words recommended).
                            Example: "Acerca de", "Programas", "Contacto".
                        </p>
                    </div>
                    {{-- Title PT --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Title (Portuguese)
                        </label>

                        <input type="text" name="title_pt" class="form-control"
                            value="{{ old('title_pt', $menu->title_pt) }}">
                        <p class="text-muted small mt-1">
                            This is the main label shown in the website menu (Portuguese version).
                            Keep it short and clear (1–3 words recommended).
                            Example: "Sobre", "Programas", "Contato".
                        </p>
                    </div>


                    {{-- Link --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Link / URL
                        </label>

                        <input type="text" name="link" class="form-control"
                            placeholder="/about-us or https://example.com" value="{{ old('link', $menu->link) }}">
                        <p class="text-muted small mt-1">
                            This is the URL or path the menu item will link to.
                            Use a relative path for internal pages (e.g., "/about-us") or a full URL for external links
                            (e.g., "https://example.com").
                        </p>
                    </div>


                    {{-- Order --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">
                            Order
                        </label>

                        <input type="number" name="order" class="form-control"
                            value="{{ old('order', $menu->order ?? 0) }}">
                        <p class="text-muted small mt-1">
                            This controls the position of the menu item. Lower numbers appear first.
                        </p>

                    </div>


                    {{-- Parent Menu --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">
                            Parent Menu
                        </label>

                        <select name="parent_id" class="form-select">

                            <option value="">
                                Main Menu
                            </option>

                            @foreach ($parents as $id => $title)
                                <option value="{{ $id }}"
                                    {{ old('parent_id', $menu->parent_id) == $id ? 'selected' : '' }}>
                                    {{ $title }}
                                </option>
                            @endforeach

                        </select>
                        <p class="text-muted small mt-1">
                            Select a parent menu if this item should be a submenu. Leave blank for a main menu item.
                        </p>
                    </div>

                </div>


                {{-- Buttons --}}
                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">

                        {{ isset($menu->id) ? 'Update Menu' : 'Create Menu' }}

                    </button>

                    <a href="{{ route('menus.index') }}" class="btn btn-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection
