<section class="blog__section pt-130 pb-130 overhid">
    <div class="container">

        <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
            <h6>@lang('pages.blogs')</h6>
            <div class="witr_bar_main">
                <div class="witr_bar_inner witr_bar_innerc center"></div>
                <h3>@lang('pages.blogs_description')</h3>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredBlogs as $blog)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp">
                    <div class="blog__items">

                        <div class="thumb">
                            <a href="{{ route('blogs.display', $blog->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'blogs', 'id' => $blog->id]) }}"
                                    alt="">
                            </a>
                        </div>

                        <div class="content">
                            <h5>
                                <a href="{{ route('blogs.display', $blog->slug) }}">
                                    {{ $blog->getTitle() }}
                                </a>
                            </h5>

                            <p>
                                {{  $blog->limitText($blog->getContent(), 120)}}
                            </p>

                            <a href="{{ route('blogs.display', $blog->slug) }}" class="btns">
                                @lang('pages.read_more')
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>