<a
    href="{{ route('cat_list', $routeParams) }}"
    dusk="{{ $query }}_sort_{{ $direction }}"
    class="hover:tw-text-primary {{ $isActive ? ' tw-text-primary' : 'tw-text-gray-300' }}"
>
    @if($direction === 'asc')
        <i class="fas fa-angle-up"></i>
    @else
        <i class="fas fa-angle-down"></i>
    @endif
</a>
