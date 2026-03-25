@extends('admin.layouts.master')

@section('title', 'Stores')
@section('css')
    <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="uil-store"></i> Stores
            </h5>
            <a href="{{ route('stores.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Store
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered datatable-buttons">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Image</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($stores as $store)
                                    <tr>
                                        <td>
                                            <strong>{{ $store->name }}</strong>
                                        </td>

                                        <td>
                                            {{ $store->type ?? '-' }}
                                        </td>

                                        {{-- Image --}}
                                        <td class="text-center">
                                            <a href="{{ route('admin.images.edit', ['model' => 'stores', 'id' => $store->id]) }}"
                                                title="Upload / Edit image" class="me-2">
                                                <i
                                                    class="uil-image font-size-22 {{ $store->image_url ? 'text-primary' : 'text-muted' }}"></i>
                                            </a>

                                            @if($store->image_url)
                                                <a href="{{ route('admin.images.preview', ['model' => 'stores', 'id' => $store->id]) }}"
                                                    title="View image" target="_blank">
                                                    <i class="fas fa-eye font-size-6 text-primary"></i>
                                                </a>
                                            @else
                                                <i class="fas fa-eye font-size-6 text-muted"></i>
                                            @endif
                                        </td>

                                        {{-- Publish toggle --}}
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('admin.publish.toggle', [
                            'model' => Str::snake(class_basename($store)),
                            'id' => $store->id
                        ]) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="badge border-0 {{ $store->is_published ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $store->is_published ? __('Yes') : __('No') }}
                                                </button>
                                            </form>
                                        </td>

                                        {{-- Actions --}}
                                        <td>
                                            <a href="{{ route('stores.edit', $store) }}" class="btn btn-sm btn-warning">
                                                <i class="uil-pen"></i>
                                            </a>

                                            <form action="{{ route('stores.destroy', $store) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this store?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-sm btn-danger">
                                                    <i class="uil-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('/assets/admin/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/pages/datatables.init.js') }}"></script>
@endsection