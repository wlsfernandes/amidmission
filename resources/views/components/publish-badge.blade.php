<span class="badge {{ $isPublished() ? 'bg-success' : 'bg-secondary' }}">
    {{ $isPublished() ? __('Yes') : __('No') }}
</span>