@extends('layouts.app')

@php
    use Illuminate\Pagination\LengthAwarePaginator;

    /** @var LengthAwarePaginator $cats */
    $totalCats = $cats->total();

    $perPageOptions = [15, 30, $totalCats]
@endphp

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Muce, ki iščejo botra</h1>

            {{ $cats->links() }}

            <div class="block">
                <h6 class="has-text-weight-semibold">Prikaži na stran:</h6>
                @foreach($perPageOptions as $option)
                    <a
                        href="{{ route('cat_list', ['per_page' => $option]) }}"
                        dusk="per_page_{{ $option }}"
                        class="{{ $cats->perPage() === $option ? ' has-text-weight-semibold' : '' }}"
                    >
                        {{ $option }}
                    </a>
                @endforeach
            </div>

            <div class="block">
                <h6 class="has-text-weight-semibold">Razvrsti po:</h6>
                <div class="is-flex">
                    <span>številu botrov</span>
                    <a
                        href="{{ route('cat_list', ['sponsorship_count' => 'asc']) }}"
                        dusk="sponsorship_count_sort_asc"
                        class="{{ request('sponsorship_count') !== 'asc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▲
                    </a>
                    <a
                        href="{{ route('cat_list', ['sponsorship_count' => 'desc']) }}"
                        dusk="sponsorship_count_sort_desc"
                        class="{{ request('sponsorship_count') !== 'desc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▼
                    </a>
                </div>
                <div class="is-flex">
                    <span>starosti</span>
                    <a
                        href="{{ route('cat_list', ['age' => 'asc']) }}"
                        dusk="age_sort_asc"
                        class="{{ request('age') !== 'asc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▲
                    </a>
                    <a
                        href="{{ route('cat_list', ['age' => 'desc']) }}"
                        dusk="age_sort_desc"
                        class="{{ request('age') !== 'desc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▼
                    </a>
                </div>
                <div class="is-flex">
                    <span>datumu objave</span>
                    <a
                        href="{{ route('cat_list', ['id' => 'asc']) }}"
                        dusk="id_sort_asc"
                        class="{{ request('id') !== 'asc' ? 'has-text-grey-darker' : '' }}"
                    >
                        ▲
                    </a>
                    <a
                        href="{{ route('cat_list', ['id' => 'desc']) }}"
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
