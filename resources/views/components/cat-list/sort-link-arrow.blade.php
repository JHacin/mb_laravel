<a
    href="{{ route('cat_list', $routeParams) }}"
    dusk="{{ $query }}_sort_{{ $direction }}"
    class="hover:text-primary {{ $isActive ? ' text-primary' : 'text-gray-300' }}"
>
    @if($direction === 'asc')
        <i class="fas fa-angle-up"></i>
    @else
        <i class="fas fa-angle-down"></i>
    @endif
</a>
