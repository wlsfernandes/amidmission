@extends('admin.layouts.master')

@section('title', 'Services')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="uil-briefcase"></i> Services
            </h5>

            <a href="{{ route('services.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Service
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered datatable-buttons">
                <thead>
                    <tr>
                        <th></th>
                        <th>Title (EN)</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            {{-- Image --}}
                            <td class="align-middle text-center">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    @if ($service->image_url)
                                        <a href="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                                            target="_blank" title="View image">
                                            <img src="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                                                alt="Service image" class="rounded-circle mb-1"
                                                style="width:80px;height:80px;object-fit:cover;">
                                        </a>
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                                            style="width:80px;height:80px;">
                                            <i class="uil uil-image text-muted font-size-24"></i>
                                        </div>
                                    @endif

                                    {{-- Edit / Upload --}}
                                    <a href="{{ route('admin.images.edit', ['model' => 'services', 'id' => $service->id]) }}"
                                        class="text-primary small" title="Upload / Change image">
                                        <i class="uil uil-edit"></i> Edit
                                    </a>
                                </div>
                            </td>


                            {{-- Title --}}
                            <td>
                                <strong>
                                    <div class="cms-html" id="cms-html">{!! $service->title_en !!}</div>
                                </strong><br>
                            </td>


                            {{-- Published --}}
                            <td class="text-center">
                                <form method="POST"
                                    action="{{ route('admin.publish.toggle', ['model' => 'services', 'id' => $service->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $service->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $service->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this service?')">
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
