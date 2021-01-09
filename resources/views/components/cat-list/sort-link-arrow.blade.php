<a
    href="{{ route('cat_list', $routeParams) }}"
    dusk="{{ $query }}_sort_{{ $direction }}"
    class="sort-link-arrow{{ $isActive ? ' sort-link-arrow--active' : '' }}"
>
    @if($direction === 'asc')
        <i class="fas fa-angle-up"></i>
    @else
        <i class="fas fa-angle-down"></i>
    @endif
</a>
