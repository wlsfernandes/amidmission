@isset($session)
    @if ($section->cards && $section->cards->count())
        <section class="blog__section pt-80 pb-80 overhid">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <div class="cms-html mb-4">
                    {!! $section->getTitle() !!}
                </div>
                <div class="witr_bar_main">
                    <div class="witr_bar_inner witr_bar_innerc center"></div>
                    <div class="cms-html mb-4">
                        {!! $section->getContent() !!}
                    </div>
                </div>
            </div>
            <div class="container">

                <div class="row g-4">

                    @foreach ($section->cards as $card)
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp">

                            <div class="blog__items">

                                @if ($card->image_url)
                                    <div class="thumb">
                                        <img src="{{ route('admin.images.preview', ['model' => 'section_cards', 'id' => $card->id]) }}"
                                            alt="{{ $card->getTitle() }}">
                                    </div>
                                @endif

                                <div class="content">
                                    @if ($card->getTitle())
                                        <div class="cms-html">
                                            {!! $card->getTitle() !!}
                                        </div>
                                    @endif
                                    @if ($card->getContent())
                                        <div class="cms-html">
                                            {!! $card->getContent() !!}
                                        </div>
                                    @endif
                                    @if ($card->link)
                                        <a href="{{ $card->link }}" class="cmn--btn" target="_blank" rel="noopener">
                                            @lang('pages.read_more')
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endisset
