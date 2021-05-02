@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Muce, ki iščejo botra</h1>

            <div class="columns">
                <div class="column is-12-mobile is-9-desktop is-10-fullhd">
                    Na seznamu so objavljene vse muce, ki trenutno iščejo botra. Če vas zanima več o tem,
                    kaj je bistvo programa Mačji boter in kako poteka postopek botrovanja, si lahko
                    preberete več na
                    <a
                        href="{{ route('why_become_sponsor') }}"
                        class="has-text-weight-semibold"
                        dusk="why-become-sponsor-link"
                    >tej povezavi</a>.
                </div>
            </div>

            <div class="mb-6">
                <div class="cat-list-columns columns is-multiline is-mobile">
                    <div class="column is-12-mobile is-9-desktop is-10-fullhd">
                        @if($cats->isNotEmpty())
                            <div class="columns is-multiline is-mobile" dusk="cat-list-items">
                                @foreach($cats as $cat)
                                    <div
                                        class="column is-12-mobile is-6-tablet is-4-fullhd is-flex"
                                        dusk="cat-list-item-wrapper"
                                    >
                                        <x-cat-list.cat-list-item :cat="$cat" />
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div>Za vaše iskanje ni bilo najdenih rezultatov.</div>
                        @endif
                    </div>
                    <div class="column is-12-mobile is-3-desktop is-2-fullhd">
                        <div class="block">
                            <x-cat-list.search-by-name />
                        </div>

                        @if($cats->total() > 1)
                            <div class="block" dusk="sort-options-wrapper">
                                <x-cat-list.sort-links />
                            </div>
                        @endif

                        @if($cats->isNotEmpty() && $cats->total() > \App\Models\Cat::PER_PAGE_12)
                            <div class="block" dusk="per_page-options-wrapper">
                                <x-cat-list.per-page-options :cats="$cats" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-12 is-9-desktop is-10-fullhd">
                    {{ $cats->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
