<form action="{{ route('cat_list') }}" method="GET">
    @foreach(['per_page', 'sponsorship_count', 'age', 'id'] as $query)
        @isset($query)
            <input type="hidden" name="{{ $query }}" value="{{ request($query) }}">
        @endisset
    @endforeach
    <x-inputs.base.input name="search" placeholder="Išči po imenu" value="{{ request('search') }}">
        <x-slot name="addon">
            <button type="submit" class="button is-primary" dusk="search-submit">
                <span class="icon">
                    <i class="fas fa-arrow-circle-right"></i>
                </span>
            </button>
        </x-slot>
    </x-inputs.base.input>
</form>
@if(request('search'))
    <div class="mt-1">
        <a
            class="has-text-primary"
            href="{{ route('cat_list', array_merge($activeQueryParams, ['search' => null])) }}"
            dusk="clear-search-link"
        >
            Počisti iskanje
        </a>
    </div>
@endif
