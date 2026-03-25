@if ($section->external_link)
    <div class="cta-button-wrapper cta-btn-{{ $section->button_position ?? 'left' }}">

        <a href="{{ $section->external_link }}" class="cmn--btn btn-{{ $section->button_color ?? 'primary' }}"
            target="_blank">

            {{ $section->getButtonText() }}

        </a>

    </div>
@endif
