<a
    @class([
        'underline pointer-events-none' => $isActive,
        'hover:text-gray-semi transition-all' => !$isActive,
    ])
    href="{{ route('cat_list', $routeParams) }}"
    dusk="{{ $query }}_sort_toggle"
>
    {{ $label }}
</a>
