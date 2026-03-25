@extends('admin.layouts.master')

@section('title', 'Users')

@section('css')
    <link href="{{ asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border border-primary">
                <div class="card-header bg-transparent border-primary d-flex justify-content-between">
                    <h5 class="my-0 text-primary">
                        <i class="uil-chat-bubble-user"></i> User Management
                    </h5>

                    <a href="{{ route('users.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>

                <div class="card-body">
                    <x-alert />

                    <small class="text-danger d-block mb-2">
                        Attention: Temporary System Password: admin2030
                    </small>

                    <table class="table table-bordered datatable-buttons">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        {{ $user->roles->pluck('name')->join(', ') ?: '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                            <i class="uil uil-pen"></i>
                                        </a>

                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Confirm delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="uil uil-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/assets/admin/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/pages/datatables.init.js') }}"></script>
@endsection