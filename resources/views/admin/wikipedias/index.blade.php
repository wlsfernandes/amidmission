@extends('admin.layouts.master')

@section('title', 'Wikipedia')

@section('css')
    <link href="{{ asset('admin/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="card border border-primary">
                <div class="card-header bg-transparent border-primary">
                    <h5 class="my-0 text-primary"><i class="dripicons-help"></i> Wikipedia</b></h5>
                </div>
                <div class="card-body">
                    <x-alert />

                    <div>
                        <a href="{{ route('wikipedias.create') }}">
                            <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i
                                    class="fas fa-plus"></i> Add
                                New</button>
                        </a>
                    </div>

                    <h4 class="card-title">System Helper</h4>
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 200px;">Actions</th>
                                <th>Question</th>
                                <th>Date</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wikipedias as $wikipedia)
                                <tr>
                                    <td>
                                        <a href="{{ route('wikipedias.show', $wikipedia->id) }}"
                                            class="px-3 text-primary"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('wikipedias.edit', $wikipedia->id) }}"
                                            class="px-3 text-warning"><i class="uil uil-pen font-size-18"></i></a>
                                        <a href="javascript:void(0);" class="px-3 text-danger"
                                            onclick="event.preventDefault(); if(confirm('Confirm delete?')) { document.getElementById('delete-form-{{ $wikipedia->id }}').submit(); }">
                                            <i class="uil uil-trash-alt font-size-18"></i>
                                        </a>
                                        <form id="delete-form-{{ $wikipedia->id }}"
                                            action="{{ route('wikipedias.destroy', $wikipedia->id) }}" method="POST"
                                            style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td>
                                    <td>
                                        {{ $wikipedia->question ? $wikipedia->question : '' }}
                                    </td>

                                    <td>
                                        {{ $wikipedia->created_at ? $wikipedia->created_at->format('M d, Y') : '' }}

                                        <small class="d-block text-muted">
                                            Created by: {{ $wikipedia->created_by ?? '' }}
                                        </small>

                                        <small class="d-block text-muted">
                                            Updated by: {{ $wikipedia->updated_by ?? '' }}
                                        </small>
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
    <script src="{{ asset('admin/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/pages/datatables.init.js') }}"></script>
@endsection
