<div class="col-lg-5">

    @if ($section->image_url)
        <div class="section-video text-center position-relative">

            <a href="{{ $section->external_link }}" target="_blank" class="video-link">

                <img src="{{ route('admin.images.preview', [
                    'model' => 'sections',
                    'id' => $section->id,
                ]) }}"
                    alt="{{ $section->title ?? 'Section image' }}" class="img-fluid rounded shadow-sm w-100">

                <span class="video-play-icon">
                    <i class="fas fa-play"></i>
                </span>

            </a>

        </div>
    @endif

</div>
