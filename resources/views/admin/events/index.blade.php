@extends('admin.layouts.master')

@section('title', 'Events')
@section('css')
  <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="uil-calendar-alt"></i> Events
      </h5>
      <a href="{{ route('events.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add Event
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th> </th>
            <th>Title (EN)</th>
            <th>Event Date</th>
            <th>File En</th>
            <th>File Es</th>
            <th>Published</th>
            <th>Publication Window</th>
            <th width="140">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($events as $event)
            <tr>
              {{-- Image --}}
              <td class="align-middle text-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                  @if ($event->image_url)
                    <a href="{{ route('admin.images.preview', ['model' => 'events', 'id' => $event->id]) }}"
                      target="_blank" title="View image">
                      <img src="{{ route('admin.images.preview', ['model' => 'events', 'id' => $event->id]) }}"
                        alt="Event image" class="rounded-circle mb-1" style="width:80px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif

                  {{-- Edit / Upload --}}
                  <a href="{{ route('admin.images.edit', ['model' => 'events', 'id' => $event->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>

              <td>
                <strong>{{ $event->title_en }}</strong><br>
                <small class="text-muted">{{ $event->slug }}</small>
              </td>

              <td>
                {{ $event->event_date?->format('M d, Y') ?? '-' }}
              </td>

              <td class="text-center">
                <a href="{{ route('admin.files.edit', ['model' => 'events', 'id' => $event->id, 'lang' => 'en']) }}"
                  title="Upload / Edit English file" class="me-2">
                  <i class="uil-file font-size-22 {{ $event->file_url_en ? 'text-primary' : 'text-muted' }}">
                  </i>
                </a>
                @if ($event->file_url_en)
                  <a href="{{ route('admin.files.download', ['model' => 'events', 'id' => $event->id, 'lang' => 'en']) }}"
                    title="Download English file"><i class="fas fa-eye font-size-6 text-primary"></i></a>
                @else
                  <i class="fas fa-eye font-size-6 text-muted"></i>
                @endif
              </td>
              <td class="text-center">
                <a href="{{ route('admin.files.edit', ['model' => 'events', 'id' => $event->id, 'lang' => 'es']) }}"
                  title="Upload Spanish file">
                  <i class="uil-file font-size-22 {{ $event->file_url_es ? 'text-primary' : 'text-muted' }}">
                  </i>
                </a>
                @if ($event->file_url_es)
                  <a href="{{ route('admin.files.download', ['model' => 'events', 'id' => $event->id, 'lang' => 'es']) }}"
                    title="Download Spanish file">
                    <i class="fas fa-eye font-size-6 text-primary"></i>
                  </a>
                @else
                  <i class="fas fa-eye font-size-6 text-muted"></i>
                @endif
              </td>
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', ['model' => Str::snake(class_basename($event)), 'id' => $event->id]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit"
                    class="badge border-0 {{ $event->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $event->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              <td>
                <small>
                  From:
                  {{ $event->publish_start_at?->format('M d, Y') ?? '-' }}<br>
                  To:
                  {{ $event->publish_end_at?->format('M d, Y') ?? '-' }}
                </small>
              </td>

              <td>
                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this event?')">
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
