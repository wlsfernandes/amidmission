@extends('admin.layouts.master')

@section('title', 'Section Cards')

@section('content')

    <div class="card border border-primary">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>
                <h5 class="mb-0">
                    <i class="uil uil-apps"></i>
                    Section Cards
                </h5>

                <small class="text-muted">
                    Page: {{ $page->title }} | Section: {{ $section->title }}
                </small>
            </div>

            <a href="{{ route('pages.sections.cards.create', [$page, $section]) }}" class="btn btn-success">

                <i class="uil uil-plus"></i>
                Add Card

            </a>

        </div>


        <div class="card-body">
            <div class="alert alert-info mb-4">
                <h6 class="mb-2">
                    <i class="uil uil-info-circle"></i> Section Cards Guide
                </h6>

                <p class="mb-2">
                    Cards are structured items inside a section. They are used to display repeated content
                    such as services, programs, features, or benefits.
                </p>

                <ul class="mb-2">
                    <li><strong>Each card = one item</strong></li>
                    <li><strong>Cards appear in a grid or list</strong></li>
                    <li><strong>Only available for specific section types (like Content or Feature)</strong></li>
                </ul>

                <p class="mb-0">
                    <strong>Tip:</strong> Use cards when you need to display multiple similar items in a clean layout.
                </p>
            </div>
            <x-alert />

            @if ($cards->count())

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead class="table-light">
                            <tr>

                                <th width="80">Order</th>
                                <th width="120">Image</th>
                                <th>Title</th>
                                <th width="200">Actions</th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($cards as $card)
                                <tr>

                                    <td class="text-center">
                                        {{ $card->sort_order ?? '—' }}
                                    </td>

                                    <td class="text-center">

                                        @if ($card->image_url)
                                            <img src="{{ route('admin.images.preview', [
                                                'model' => 'section_cards',
                                                'id' => $card->id,
                                            ]) }}"
                                                class="img-thumbnail" style="max-width:80px">
                                        @else
                                            <span class="text-muted small">No image</span>
                                        @endif

                                    </td>

                                    <td>
                                        <strong>{!! $card->getTitle() ?? '' !!}</strong>
                                    </td>

                                    <td>
                                        <a href="{{ route('pages.sections.cards.edit', [$page, $section, $card]) }}"
                                            class="btn btn-sm btn-warning">


                                            <i class="uil uil-pen"></i>

                                        </a>

                                        <form action="{{ route('pages.sections.cards.destroy', [$page, $section, $card]) }}"
                                            method="POST" class="d-inline" onsubmit="return confirm('Delete this card?')">

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
            @else
                <div class="text-center text-muted py-5">

                    <i class="uil uil-apps font-size-40"></i>

                    <p class="mt-3 mb-0">
                        No cards created yet.
                    </p>

                    <p class="small">
                        Click <strong>Add Card</strong> to create the first one.
                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection
