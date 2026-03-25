<!--Team Section Here-->
<section class="team__section pt-130 pb-130 overhid">
    <div class="container">

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

        <div id="sectionGallery{{ $section->id }}" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-inner">

                @foreach ($section->images->chunk(4) as $chunkIndex => $images)
                    <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">

                        <div class="row g-4">

                            @foreach ($images as $image)
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4">

                                    <div class="team__items position-relative">

                                        <div class="team__thumb">

                                            <img src="{{ route('admin.images.preview', [
                                                'model' => 'section_images',
                                                'id' => $image->id,
                                            ]) }}"
                                                alt="Gallery Image" loading="lazy">

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- Controls --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#sectionGallery{{ $section->id }}"
                data-bs-slide="prev">

                <span class="carousel-control-prev-icon"></span>

            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#sectionGallery{{ $section->id }}"
                data-bs-slide="next">

                <span class="carousel-control-next-icon"></span>

            </button>

        </div>

    </div>
</section>
<!--Team Section End-->
