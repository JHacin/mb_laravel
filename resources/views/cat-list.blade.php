@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container mx-auto">
            <h1 class="title">Muce, ki iščejo botra</h1>

            <div class="grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-5 gap-x-6 gap-y-8">
                <div class="col-span-full lg:col-span-3 xl:col-span-4">
                    Na seznamu so objavljene vse muce, ki trenutno iščejo botra. Če vas zanima več o tem,
                    kaj je bistvo programa Mačji boter in kako poteka postopek botrstva, si lahko
                    preberete več na
                    <a
                      href="{{ route('why_become_sponsor') }}"
                      class="font-semibold"
                      dusk="why-become-sponsor-link"
                    >tej povezavi</a>.
                </div>

                <div class="col-span-full lg:col-span-3 xl:col-span-4">
                    @if($cats->isNotEmpty())
                        <div
                          class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6"
                          dusk="cat-list-items"
                        >
                            @foreach($cats as $cat)
                                <div class="flex" dusk="cat-list-item-wrapper">
                                    <x-cat-list.cat-list-item :cat="$cat" />
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div>Za vaše iskanje ni bilo najdenih rezultatov.</div>
                    @endif
                </div>

                <div class="col-span-full lg:col-span-1 xl:col-span-1 row-start-2 lg:col-start-4 xl:col-start-5">
                    <div class="content-block">
                        <x-cat-list.search-by-name :numResults="$cats->total()" />
                    </div>

                    @if($cats->total() > 1)
                        <div class="content-block" dusk="sort-options-wrapper">
                            <x-cat-list.sort-links />
                        </div>
                    @endif

                    @if($cats->isNotEmpty() && $cats->total() > \App\Models\Cat::PER_PAGE_12)
                        <div class="content-block" dusk="per_page-options-wrapper">
                            <x-cat-list.per-page-options :cats="$cats" />
                        </div>
                    @endif
                </div>

                <div class="col-span-full lg:col-span-3 xl:col-span-4">
                    {{ $cats->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
