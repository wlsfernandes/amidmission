@extends('admin.layouts.master')

@section('title', 'Media')

@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="uil uil-play-circle"></i> Media
      </h5>

      <a href="{{ route('media.create') }}" class="btn btn-success">
        <i class="uil uil-plus"></i> Add Media
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th>Type</th>
            <th>Title</th>
            <th>External Link</th>
            <th>Published At</th>
            <th>Published</th>
            <th width="140">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($media as $item)
            <tr>

              {{-- Type --}}
              <td>
                <span class="badge bg-primary">
                  {{ $item->type->name ?? '—' }}
                </span>
              </td>

              {{-- Title (localized) --}}
              <td>
                <strong>{{ $item->title }}</strong>

                <div class="small text-muted mt-1">
                  EN: {{ $item->title_en }}<br>
                  ES: {{ $item->title_es }}
                </div>
              </td>

              {{-- External link --}}
              <td>
                @if ($item->external_link)
                  <a href="{{ $item->external_link }}" target="_blank" rel="noopener noreferrer"
                    class="text-decoration-none">
                    <i class="uil uil-external-link-alt"></i>
                    {{ Str::limit($item->external_link, 40) }}
                  </a>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>

              {{-- Published at --}}
              <td>
                {{ $item->published_at ? $item->published_at->format('M d, Y') : '—' }}
              </td>

              {{-- Publish toggle --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', [
                      'model' => 'medias',
                      'id' => $item->id,
                  ]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit" class="badge border-0 {{ $item->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $item->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('media.edit', $item) }}" class="btn btn-sm btn-warning">
                  <i class="uil uil-pen"></i>
                </a>

                <form action="{{ route('media.destroy', $item) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this media item?')">
                  @csrf
                  @method('DELETE')

                  <button class="btn btn-sm btn-danger">
                    <i class="uil uil-trash"></i>
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
