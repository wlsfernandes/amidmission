@extends('admin.layouts.master')

@section('title', 'Partnerships')

@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="uil-briefcase"></i> Partnerships
      </h5>
      <a href="{{ route('collaborators.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add Partnership
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th>BannerPage</th>
            <th>Gallery</th>
            <th>Title</th>
            <th>Period</th>
            <th>Order</th>
            <th>Published</th>
            <th width="140">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($collaborators as $collaborator)
            @php
              $coverImage = $collaborator->images->first();
            @endphp

            <tr>
              <td class="d-flex justify-content-center align-items-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                  @if ($collaborator->image_url)
                    <a href="{{ route('admin.images.preview', ['model' => 'collaborators', 'id' => $collaborator->id]) }}"
                      target="_blank" title="View image">
                      <img src="{{ route('admin.images.preview', ['model' => 'collaborators', 'id' => $collaborator->id]) }}"
                        alt="Banner image" class="rounded-circle mb-1" style="width:80px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif

                  <a href="{{ route('admin.images.edit', ['model' => 'collaborators', 'id' => $collaborator->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>
              {{-- Gallery preview (cover image) --}}

              <td class="align-middle text-center">
                <a href="{{ route('collaborators.images.index', $collaborator) }}" class="btn btn-outline-primary btn-sm"
                  title="View project images">
                  <i class="uil uil-images"></i>
                </a>

                <div class="small text-muted mt-1">
                  {{ $collaborator->images->count() }}
                  image{{ $collaborator->images->count() === 1 ? '' : 's' }}
                </div>
              </td>
              {{-- Title (localized) --}}
              <td>

                <strong>
                  <a href="{{ route('collaborators.display', $collaborator->slug) }}" target="_blank" class="text-decoration-none">
                    {{ $collaborator->title }}
                  </a>
                </strong>

                <div class="small text-muted mt-1">
                  <i class="uil uil-link"></i>
                  <a href="{{ route('collaborators.display', $collaborator->slug) }}" target="_blank" class="text-decoration-none">
                    {{ route('collaborators.display', $collaborator->slug) }}
                  </a>
                </div>
              </td>

              {{-- Period --}}
              <td>
                @if ($collaborator->start_date || $collaborator->end_date)
                  <small class="text-muted">
                    {{ $collaborator->start_date ? $collaborator->start_date->format('M d, Y') : '—' }}
                    →
                    {{ $collaborator->end_date ? $collaborator->end_date->format('M d, Y') : '—' }}
                  </small>
                @else
                  <span class="text-muted">—</span>
                @endif
                <br />
                <small><a href="{{ $collaborator->external_link }}" target="_blank" class="text-decoration-none">
                    {{ $collaborator->external_link }} </a></small>
              </td>

              <td>{{ $collaborator->order }}</td>



              {{-- Publish toggle --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', [
                      'model' => 'projects',
                      'id' => $collaborator->id,
                  ]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit"
                    class="badge border-0 {{ $collaborator->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $collaborator->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('collaborators.edit', $collaborator) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('collaborators.destroy', $collaborator) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this project?')">
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
