@extends('admin.layouts.master')

@section('title', 'Team')
@section('css')
  <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="fas fa-users"></i> Team
      </h5>

      <a href="{{ route('teams.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add Team Member
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>Role</th>
            <th>Sector</th>
            <th>Published</th>
            <th width="140">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($teams as $team)
            <tr>
              <td class="align-middle text-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                  @if ($team->image_url)
                    <a href="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}" target="_blank"
                      title="View image">
                      <img src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                        alt="Team image" class="rounded-circle mb-1" style="width:80px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif

                  {{-- Edit / Upload --}}
                  <a href="{{ route('admin.images.edit', ['model' => 'teams', 'id' => $team->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>

              {{-- Name --}}
              <td>
                <strong>{{ $team->name }}</strong>
              </td>

              {{-- Role --}}
              <td>
                <small class="text-muted">
                  {{ $team->role ?? '-' }}
                </small>
              </td>

              {{-- Sector --}}
              <td>
                @foreach ($team->sectors as $sector)
                  <span class="badge bg-secondary me-1">
                    {{ $sector->name }}
                  </span>
                @endforeach
              </td>


              {{-- Published --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', ['model' => 'teams', 'id' => $team->id]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit" class="badge border-0 {{ $team->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $team->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('teams.edit', $team) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('teams.destroy', $team) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this team member?')">
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
