@extends('admin.layouts.master')

@section('title', 'Book Recommendations')

@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="uil uil-book-open"></i> Book Recommendations
      </h5>

      <a href="{{ route('book-recommendations.create') }}" class="btn btn-success">
        <i class="uil uil-plus"></i> Add Book
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th width="90">Cover</th>
            <th>Title</th>
            <th>Description</th>
            <th width="140">Actions</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($books as $book)
            <tr>

              {{-- Cover Image --}}
              <td class="text-center align-middle">
                <div class="d-flex flex-column align-items-center justify-content-center">

                  @if ($book->image_url)
                    <a href="{{ route('admin.images.preview', [
                        'model' => 'book-recommendations',
                        'id' => $book->id,
                    ]) }}"
                      target="_blank">
                      <img
                        src="{{ route('admin.images.preview', [
                            'model' => 'book-recommendations',
                            'id' => $book->id,
                        ]) }}"
                        alt="Book cover" class="rounded" style="width:60px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif

                  <a href="{{ route('admin.images.edit', ['model' => 'book-recommendations', 'id' => $book->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>

              {{-- Title --}}
              <td>
                <strong>{{ $book->title }}</strong>

                <div class="small text-muted mt-1">
                  EN: {{ $book->title_en }}<br>
                  ES: {{ $book->title_es ?? '—' }}
                </div>
              </td>

              {{-- Description --}}
              <td>
                <small class="text-muted">
                  {{ \Illuminate\Support\Str::limit(strip_tags($book->description), 120) }}
                </small>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('book-recommendations.edit', $book) }}" class="btn btn-sm btn-warning">
                  <i class="uil uil-pen"></i>
                </a>

                <form action="{{ route('book-recommendations.destroy', $book) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this book recommendation?')">
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
