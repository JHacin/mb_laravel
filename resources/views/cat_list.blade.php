@extends('layouts.app')

@php
    use Illuminate\Pagination\LengthAwarePaginator;

    /** @var LengthAwarePaginator $cats */
    $totalCats = $cats->total();

    $perPageOptions = [
        15 => 15,
        30 => 30,
        $totalCats => 'vse',
    ]
@endphp

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Muce, ki iščejo botra</h1>

            {{ $cats->links() }}

            <div class="block">
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
                        href="{{ route('cat_list', ['search' => null, 'per_page' => request('per_page'), 'sponsorship_count' => request('sponsorship_count'), 'age' => request('age'), 'id' => request('id')]) }}"
                        dusk="clear-search-link"
                    >
                        Počisti iskanje
                    </a>
                @endif
            </div>

            <div class="block">
                <h6 class="has-text-weight-semibold">Prikaži na stran:</h6>
                @foreach($perPageOptions as $option => $label)
                    <a
                        href="{{ route('cat_list', ['per_page' => $option, 'sponsorship_count' => request('sponsorship_count'), 'age' => request('age'), 'id' => request('id'), 'search' => request('search')]) }}"
                        dusk="per_page_{{ $option }}"
                        class="{{ $cats->perPage() === $option ? ' has-text-weight-semibold' : '' }}"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="block">
                <h6 class="has-text-weight-semibold">Razvrsti po:</h6>
                <div class="is-flex">
                    <span>številu botrov</span>
                    <a
                        href="{{ route('cat_list', ['per_page' => request('per_page'), 'sponsorship_count' => 'asc', 'search' => request('search')]) }}"
                        dusk="sponsorship_count_sort_asc"
                        class="{{ request('sponsorship_count') !== 'asc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▲
                    </a>
                    <a
                        href="{{ route('cat_list', ['per_page' => request('per_page'), 'sponsorship_count' => 'desc', 'search' => request('search')]) }}"
                        dusk="sponsorship_count_sort_desc"
                        class="{{ request('sponsorship_count') !== 'desc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▼
                    </a>
                </div>
                <div class="is-flex">
                    <span>starosti</span>
                    <a
                        href="{{ route('cat_list', ['per_page' => request('per_page'), 'age' => 'asc', 'search' => request('search')]) }}"
                        dusk="age_sort_asc"
                        class="{{ request('age') !== 'asc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▲
                    </a>
                    <a
                        href="{{ route('cat_list', ['per_page' => request('per_page'), 'age' => 'desc', 'search' => request('search')]) }}"
                        dusk="age_sort_desc"
                        class="{{ request('age') !== 'desc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▼
                    </a>
                </div>
                <div class="is-flex">
                    <span>datumu objave</span>
                    <a
                        href="{{ route('cat_list', ['per_page' => request('per_page'), 'id' => 'asc', 'search' => request('search')]) }}"
                        dusk="id_sort_asc"
                        class="{{ request('id') !== 'asc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▲
                    </a>
                    <a
                        href="{{ route('cat_list', ['per_page' => request('per_page'), 'id' => 'desc', 'search' => request('search')]) }}"
                        dusk="id_sort_desc"
                        class="{{ request('id') === 'asc' || request('age') || request('sponsorship_count') ? 'has-text-grey-darker' : '' }}"
                    >
                        ▼
                    </a>
                </div>
            </div>

            <div class="columns is-multiline" dusk="cat-list-items">
                @foreach($cats as $cat)
                    <div class="column is-one-third" dusk="cat-list-item-wrapper">
                        <x-cat-list-item :cat="$cat"/>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
