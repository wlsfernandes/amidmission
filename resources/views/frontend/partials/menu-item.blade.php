<li class="{{ $item->children->count() ? 'has-submenu' : '' }}">
    <a href="{{ $item->link ?: '#' }}">
        {{ $item->title }}

        @if ($item->children->count())
            <i class="fas fa-chevron-down"></i>
        @endif
    </a>

    @if ($item->children->count())
        <ul class="sub-menu">
            @foreach ($item->children as $child)
                @include('frontend.partials.menu-item', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>
