@extends('admin.layouts.master')

@section('title', 'Menus')

@section('content')

    <div class="card border border-primary">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="uil uil-bars"></i> Menu Manager
            </h5>

            <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm">
                <i class="uil uil-plus"></i> Add Menu
            </a>
        </div>

        <div class="card-body">
            <div class="alert alert-info mb-4">
                <h6 class="mb-2">
                    <i class="uil uil-info-circle"></i> Menu Manager Guide
                </h6>

                <p class="mb-2">
                    The Menu Manager allows you to control the navigation of your website.
                    These menus appear in the main header and help users navigate your site.
                </p>

                <ul class="mb-2">
                    <li><strong>Main Menu:</strong> Top-level navigation items (e.g., Home, About, Contact)</li>
                    <li><strong>Submenu:</strong> Dropdown items under a main menu</li>
                    <li><strong>Order:</strong> Controls the position (lower numbers appear first)</li>
                </ul>

                <p class="mb-0">
                    <strong>Tip:</strong> Keep menu titles short and clear. Avoid too many submenu levels.
                </p>
            </div>
            <x-alert />

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th>Title EN</th>
                            <th>Title ES</th>
                            <th>Link</th>
                            <th width="80">Order</th>
                            <th width="140">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($menus as $menu)
                            {{-- Main Menu --}}
                            <tr class="table-primary">
                                <td>{{ $menu->id }}</td>

                                <td>
                                    <strong>{{ $menu->title_en }}</strong>
                                </td>

                                <td>{{ $menu->title_es }}</td>

                                <td>{{ $menu->link }}</td>

                                <td>{{ $menu->order }}</td>

                                <td class="text-center">

                                    <a href="{{ route('menus.edit', $menu) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('menus.destroy', $menu) }}" method="POST"
                                        style="display:inline-block" onsubmit="return confirm('Delete this menu?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>

                                    </form>

                                </td>
                            </tr>

                            {{-- Submenus --}}
                            @foreach ($menu->children as $child)
                                <tr>
                                    <td>{{ $child->id }}</td>

                                    <td>
                                        <span class="ms-4 text-muted">
                                            └ {{ $child->title_en }}
                                        </span>
                                    </td>

                                    <td>{{ $child->title_es }}</td>

                                    <td>{{ $child->link }}</td>

                                    <td>{{ $child->order }}</td>

                                    <td class="text-center">

                                        <a href="{{ route('menus.edit', $child) }}" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('menus.destroy', $child) }}" method="POST"
                                            style="display:inline-block" onsubmit="return confirm('Delete this menu?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger">
                                                Delete
                                            </button>

                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
