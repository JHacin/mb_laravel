<div class="flex items-center space-x-4">
    <div>Prikaži na stran:</div>

    <div class="flex items-center space-x-4">
        @foreach ($options as $option => $label)
            @if ($cats->total() >= $option)
                <a
                    href="{{ route('cat_list', array_merge(['per_page' => $option], $activeQueryParams)) }}"
                    dusk="per_page_{{ $option }}"
                >
                    <x-option-box
                        label="{{ $label }}"
                        :is-active="$activeOption == $option"
                    ></x-option-box>

                </a>
            @endif
        @endforeach
    </div>
</div>
