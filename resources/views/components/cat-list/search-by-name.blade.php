@props(['numResults'])

<form action="{{ route('cat_list') }}" method="GET">
    @foreach(['per_page', 'sponsorship_count', 'age', 'id'] as $query)
        @isset($query)
            <input type="hidden" name="{{ $query }}" value="{{ request($query) }}">
        @endisset
    @endforeach
    <x-inputs.base.input name="search" placeholder="Išči po imenu" value="{{ request('search') }}">
        <x-slot name="addon">
            <x-button variant="primary" dusk="search-submit">
                <span class="icon">
                    <i class="fas fa-arrow-circle-right"></i>
                </span>
            </x-button>
        </x-slot>
    </x-inputs.base.input>
</form>
@if(request('search'))
    <div class="mt-2">
        <div class="mb-1">
            <span class="font-semibold">Št. rezultatov:</span>
            <span>{{ $numResults }}</span>
        </div>

        <div>
            <a
                class="text-primary"
                href="{{ route('cat_list', array_merge($activeQueryParams, ['search' => null])) }}"
                dusk="clear-search-link"
            >
                Počisti iskanje
            </a>
        </div>
    </div>
@endif
