<a
    class="sort-link-toggle{{ $isActive ? ' sort-link-toggle--active' : '' }}"
    href="{{ route('cat_list', $routeParams) }}"
    dusk="{{ $query }}_sort_toggle"
>
    {{ $label }}
</a>
