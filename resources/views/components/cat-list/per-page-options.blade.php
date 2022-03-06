<div class="flex items-center space-x-4">
    <div class="font-extrabold">Na stran:</div>

    <div class="flex items-center space-x-2">
        @foreach ($options as $option => $label)
            @if ($cats->total() >= $option)
                <a
                    href="{{ route('cat_list', array_merge(['per_page' => $option], $activeQueryParams)) }}"
                    @class([
                        'mb-pagination-btn',
                        'mb-pagination-btn-active' => $activeOption == $option,
                    ])
                    dusk="per_page_{{ $option }}"
                >
                    {{ $label }}
                </a>
            @endif
        @endforeach
    </div>
</div>
