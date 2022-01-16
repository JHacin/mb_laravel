<div class="flex items-center space-x-4">
    <h6 class="font-semibold">Prikaži na stran:</h6>

    <div class="flex items-center space-x-2">
        @foreach($options as $option => $label)
            @if($cats->total() >= $option)
                <a
                    href="{{ route('cat_list', array_merge(['per_page' => $option], $activeQueryParams)) }}"
                    dusk="per_page_{{ $option }}"
                    class="mr-1 per-page-option{{ $activeOption == $option ? ' font-semibold' : '' }}"
                >
                    {{ $label }}
                </a>
            @endif
        @endforeach
    </div>
</div>
