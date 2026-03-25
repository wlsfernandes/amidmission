@php
    $view = match ($section->feature_type) {
        'team' => 'frontend.partials.team-carousel',
        'partners' => 'frontend.partials.partners',
        'testimonial' => 'frontend.partials.testimonial',
        'services' => 'frontend.partials.services-carousel',
        'blog' => 'frontend.partials.blog-carousel',
        'donate' => 'frontend.partials.donate-carousel',
        'event' => 'frontend.partials.event-carousel',
        'contact' => 'frontend.partials.contact',
        default => null,
    };
@endphp

@if ($view && view()->exists($view))
    @include($view, ['section' => $section])
@endif
