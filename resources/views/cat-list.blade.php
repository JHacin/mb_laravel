@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Muce, ki iščejo botra</h1>

            {{ $cats->links() }}

            <div class="block">
                <x-cat-list.search-by-name />
            </div>

            @if($cats->isNotEmpty() && $cats->total() > 15)
                <div class="block" dusk="per_page-options-wrapper">
                    <x-cat-list.per-page-options :cats="$cats" />
                </div>
            @endif

            @if($cats->total() > 1)
                <div class="block" dusk="sort-options-wrapper">
                    <x-cat-list.sort-links />
                </div>
            @endif

            @if($cats->isNotEmpty())
                <div class="columns is-multiline" dusk="cat-list-items">
                    @foreach($cats as $cat)
                        <div class="column is-one-third" dusk="cat-list-item-wrapper">
                            <x-cat-list.cat-list-item :cat="$cat"/>
                        </div>
                    @endforeach
                </div>
            @else
                <div>Za vaše iskanje ni bilo najdenih rezultatov.</div>
            @endif
        </div>
    </section>
@endsection
