<a
    href="{{ route('cat_list', $routeParams) }}"
    dusk="{{ $query }}_sort_{{ $direction }}"
    class="{{ $isActive ? '' : 'has-text-grey-darker' }}"
>
    @if($direction === 'asc')
        ▲
    @else
        ▼
    @endif
</a>
