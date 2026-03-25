@extends('admin.layouts.master')

@section('title', 'Open Positions')
@section('css')
  <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="fas fa-briefcase"></i> Open Positions
      </h5>

      <a href="{{ route('positions.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add Position
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th></th>
            <th>Title (EN)</th>
            <th>File EN</th>
            <th>File ES</th>
            <th>Published</th>
            <th>Publication Window</th>
            <th width="140">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($positions as $position)
            <tr>
              {{-- Image --}}
              <td class="d-flex justify-content-center align-items-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                  @if ($position->image_url)
                    <a href="{{ route('admin.images.preview', ['model' => 'positions', 'id' => $position->id]) }}"
                      target="_blank" title="View image">
                      <img src="{{ route('admin.images.preview', ['model' => 'positions', 'id' => $position->id]) }}"
                        alt="Position image" class="rounded-circle mb-1" style="width:80px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif

                  <a href="{{ route('admin.images.edit', ['model' => 'positions', 'id' => $position->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>

              {{-- Title --}}
              <td>
                <strong>{{ $position->title_en }}</strong><br>
                <small class="text-muted">
                  {{ $position->title_es ?? '-' }}
                </small>
              </td>



              {{-- File EN --}}
              <td class="text-center">
                <a href="{{ route('admin.files.edit', ['model' => 'positions', 'id' => $position->id, 'lang' => 'en']) }}"
                  title="Upload / Edit English file" class="me-2">
                  <i class="uil-file font-size-22 {{ $position->file_url_en ? 'text-primary' : 'text-muted' }}"></i>
                </a>

                @if ($position->file_url_en)
                  <a href="{{ route('admin.files.download', ['model' => 'positions', 'id' => $position->id, 'lang' => 'en']) }}"
                    title="Download English file">
                    <i class="fas fa-eye font-size-6 text-primary"></i>
                  </a>
                @else
                  <i class="fas fa-eye font-size-6 text-muted"></i>
                @endif
              </td>

              {{-- File ES --}}
              <td class="text-center">
                <a href="{{ route('admin.files.edit', ['model' => 'positions', 'id' => $position->id, 'lang' => 'es']) }}"
                  title="Upload / Edit Spanish file">
                  <i class="uil-file font-size-22 {{ $position->file_url_es ? 'text-primary' : 'text-muted' }}"></i>
                </a>

                @if ($position->file_url_es)
                  <a href="{{ route('admin.files.download', ['model' => 'positions', 'id' => $position->id, 'lang' => 'es']) }}"
                    title="Download Spanish file">
                    <i class="fas fa-eye font-size-6 text-primary"></i>
                  </a>
                @else
                  <i class="fas fa-eye font-size-6 text-muted"></i>
                @endif
              </td>

              {{-- Published --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', ['model' => 'positions', 'id' => $position->id]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit"
                    class="badge border-0 {{ $position->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $position->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Publication Window --}}
              <td>
                <small>
                  From:
                  {{ $position->publish_start_at?->format('M d, Y') ?? '-' }}<br>
                  To:
                  {{ $position->publish_end_at?->format('M d, Y') ?? '-' }}
                </small>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('positions.edit', $position) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('positions.destroy', $position) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this position?')">
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
