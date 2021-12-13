<a
    class="{{ $isActive ? ' tw-font-semibold' : '' }}"
    href="{{ route('cat_list', $routeParams) }}"
    dusk="{{ $query }}_sort_toggle"
>
    {{ $label }}
</a>
