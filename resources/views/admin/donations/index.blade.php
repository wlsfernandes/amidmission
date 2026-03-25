@extends('admin.layouts.master')

@section('title', 'Donations')

@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="uil-heart"></i> Donations
      </h5>
      <a href="{{ route('donations.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add Donation
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th></th>
            <th>Title</th>
            <th>Suggested Amount</th>
            <th>Published</th>
            <th width="140">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($donations as $donation)
            <tr>
              <td class="d-flex justify-content-center align-items-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                  @if ($donation->image_url)
                    <a href="{{ route('admin.images.preview', ['model' => 'donations', 'id' => $donation->id]) }}"
                      target="_blank" title="View image">
                      <img src="{{ route('admin.images.preview', ['model' => 'donations', 'id' => $donation->id]) }}"
                        alt="Donation image" class="rounded-circle mb-1" style="width:80px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif
                  {{-- Edit / Upload action --}}
                  <a href="{{ route('admin.images.edit', ['model' => 'donations', 'id' => $donation->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>
              {{-- Title (auto-localized via model accessor) --}}
              <td>
                <strong>{{ $donation->title }}</strong>
              </td>

              {{-- Suggested Amount --}}
              <td>
                @if ($donation->suggested_amount)
                  {{ number_format($donation->suggested_amount, 2) }}
                  <small class="text-muted">{{ $donation->currency }}</small>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>




              {{-- Publish toggle --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', [
                      'model' => Str::snake(class_basename($donation)),
                      'id' => $donation->id,
                  ]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit"
                    class="badge border-0 {{ $donation->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $donation->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('donations.edit', $donation) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('donations.destroy', $donation) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this donation?')">
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
