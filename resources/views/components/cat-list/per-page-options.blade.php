<h6 class="has-text-weight-semibold">Prikaži na stran:</h6>
@foreach($options as $option => $label)
    @if($cats->total() >= $option)
        <a
            href="{{ route('cat_list', array_merge(['per_page' => $option], $activeQueryParams)) }}"
            dusk="per_page_{{ $option }}"
            class="{{ $cats->perPage() === $option ? ' has-text-weight-semibold' : '' }}"
        >
            {{ $label }}
        </a>
    @endif
@endforeach
