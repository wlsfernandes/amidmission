@extends('admin.layouts.master')

@section('title', 'Partners')
@section('css')
  <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="fas fa-handshake"></i> Partners
      </h5>

      <a href="{{ route('partners.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add Partner
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>External Link</th>
            <th>Published</th>
            <th width="140">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($partners as $partner)
            <tr>
              {{-- Image --}}
              <td class="d-flex justify-content-center align-items-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                  @if ($partner->image_url)
                    <a href="{{ route('admin.images.preview', ['model' => 'partners', 'id' => $partner->id]) }}"
                      target="_blank" title="View image">
                      <img src="{{ route('admin.images.preview', ['model' => 'partners', 'id' => $partner->id]) }}"
                        alt="Partner image" class="rounded-circle mb-1" style="width:80px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif

                  <a href="{{ route('admin.images.edit', ['model' => 'partners', 'id' => $partner->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>
              {{-- Name --}}
              <td>
                {{ $partner->name ?? '-' }}
              </td>


              {{-- External Link --}}
              <td class="text-center">
                @if ($partner->external_link)
                  <a href="{{ $partner->external_link }}" target="_blank" class="text-primary"
                    title="Visit partner website">
                    <i class="fas fa-external-link-alt"></i>
                  </a>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>

              {{-- Published --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', ['model' => 'partners', 'id' => $partner->id]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit"
                    class="badge border-0 {{ $partner->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $partner->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('partners.edit', $partner) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('partners.destroy', $partner) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this partner?')">
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
