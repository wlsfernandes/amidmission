@extends('admin.layouts.master')

@section('title', 'About Pages')
@section('css')
  <link href="{{ asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="uil-file-alt"></i> About Us Page
      </h5>

      <a href="{{ route('abouts.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add About Page
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
            <th>Publication Window</th>
            <th width="140">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($abouts as $about)
            <tr>
              {{-- Image --}}
              <td class="d-flex justify-content-center align-items-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                  @if ($about->image_url)
                    <a href="{{ route('admin.images.preview', ['model' => 'about', 'id' => $about->id]) }}"
                      target="_blank" title="View image">
                      <img src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $about->id]) }}"
                        alt="About image" class="rounded-circle mb-1" style="width:80px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif

                  <a href="{{ route('admin.images.edit', ['model' => 'about', 'id' => $about->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>

              {{-- Title --}}
              <td>
                <strong>Section: {{ $about->section }}</strong> <br>
                {{ $about->title_en }}
              </td>




              {{-- Published --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', ['model' => 'about', 'id' => $about->id]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit"
                    class="badge border-0 {{ $about->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $about->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Publication Window --}}
              <td>
                <small>
                  From:
                  {{ $about->publish_start_at?->format('M d, Y') ?? '-' }}<br>
                  To:
                  {{ $about->publish_end_at?->format('M d, Y') ?? '-' }}
                </small>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('abouts.edit', $about) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('abouts.destroy', $about) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this About page?')">
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
