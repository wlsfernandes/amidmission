@extends('frontend.layouts.app')

@section('title', $blog->getTitle() . ' | Amid Mission')

@section('content')
    <section class="details__section pt-130 pb-130 overhid">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-10">
                    <div class="details__items">

                        <div class="details__thumb mb-4">
                            <img src="{{ route('admin.images.preview', ['model' => 'blogs', 'id' => $blog->id]) }}"
                                alt="{{ $blog->getTitle() }}">
                        </div>

                        <div class="details__content">
                            <h2>{{ $blog->getTitle() }}</h2>
                            <div class="cms-html" id="cms-html">
                                {!! $blog->getContent() !!}
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">

                            {{-- Download file --}}
                            @if ($blog->hasDownloadFile())
                                <a href="{{ route('admin.files.download', [
                                    'model' => 'blogs',
                                    'id' => $blog->id,
                                    'lang' => app()->getLocale(),
                                ]) }}"
                                    class="cmn--btn" target="_blank">
                                    @lang('pages.download_file')
                                </a>
                            @endif

                            {{-- External link --}}
                            @if (!empty($blog->external_link))
                                <a href="{{ $blog->external_link }}" class="cmn--btn cmn--btn-outline" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="uil uil-external-link-alt"></i>
                                    @lang('pages.apply_now')
                                </a>
                            @endif

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
