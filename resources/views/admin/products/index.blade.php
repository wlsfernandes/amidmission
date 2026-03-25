@extends('admin.layouts.master')

@section('title', 'Products')

@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="uil-box"></i> Products
      </h5>
      <a href="{{ route('products.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add Product
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>Store</th>
            <th>Price</th>
            <th>Type</th>
            <th>Published</th>
            <th width="140">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $product)
            <tr>
              {{-- Image --}}
              <td class="align-middle text-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                  @if ($product->image_url)
                    <a href="{{ route('admin.images.preview', ['model' => 'products', 'id' => $product->id]) }}"
                      target="_blank" title="View image">
                      <img src="{{ route('admin.images.preview', ['model' => 'products', 'id' => $product->id]) }}"
                        alt="Product image" class="rounded-circle mb-1" style="width:80px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif

                  {{-- Edit / Upload --}}
                  <a href="{{ route('admin.images.edit', ['model' => 'products', 'id' => $product->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>

              {{-- Name --}}
              <td>
                <strong>{{ $product->name }}</strong>
              </td>

              <td>
                {{ $product->store->name ?? '-' }}
              </td>

              <td>
                {{ number_format($product->price, 2) }}
                <small class="text-muted">{{ $product->currency }}</small>
              </td>

              <td>
                {{ $product->type ?? '-' }}
              </td>


              {{-- Publish toggle --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', [
                      'model' => Str::snake(class_basename($product)),
                      'id' => $product->id,
                  ]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit"
                    class="badge border-0 {{ $product->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $product->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this product?')">
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
