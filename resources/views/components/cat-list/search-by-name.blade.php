<form action="{{ route('cat_list') }}" method="GET">
    @foreach(['per_page', 'sponsorship_count', 'age', 'id'] as $query)
        @isset($query)
            <input type="hidden" name="{{ $query }}" value="{{ request($query) }}">
        @endisset
    @endforeach
    <x-inputs.base.input name="search" label="Išči po imenu" value="{{ request('search') }}" />
    <button type="submit" class="button is-primary" dusk="search-submit">Potrdi</button>
</form>
@if(request('search'))
    <a
        class="has-text-secondary"
        href="{{ route('cat_list', array_merge($activeQueryParams, ['search' => null])) }}"
        dusk="clear-search-link"
    >
        Počisti iskanje
    </a>
@endif
