@extends('layouts.app')

@section('content')
    <section class="tw-section">
        <div class="tw-container tw-mx-auto">
            <h1 class="tw-title">Muce, ki iščejo botra</h1>

            <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-4 xl:tw-grid-cols-5 tw-gap-x-6 tw-gap-y-8">
                <div class="tw-col-span-full lg:tw-col-span-3 xl:tw-col-span-4">
                    Na seznamu so objavljene vse muce, ki trenutno iščejo botra. Če vas zanima več o tem,
                    kaj je bistvo programa Mačji boter in kako poteka postopek botrstva, si lahko
                    preberete več na
                    <a
                      href="{{ route('why_become_sponsor') }}"
                      class="tw-font-semibold"
                      dusk="why-become-sponsor-link"
                    >tej povezavi</a>.
                </div>

                <div class="tw-col-span-full lg:tw-col-span-3 xl:tw-col-span-4">
                    @if($cats->isNotEmpty())
                        <div
                          class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 xl:tw-grid-cols-3 tw-gap-6"
                          dusk="cat-list-items"
                        >
                            @foreach($cats as $cat)
                                <div class="tw-flex" dusk="cat-list-item-wrapper">
                                    <x-cat-list.cat-list-item :cat="$cat" />
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div>Za vaše iskanje ni bilo najdenih rezultatov.</div>
                    @endif
                </div>

                <div class="tw-col-span-full lg:tw-col-span-1 xl:tw-col-span-1 tw-row-start-2 lg:tw-col-start-4 xl:tw-col-start-5">
                    <div class="tw-content-block">
                        <x-cat-list.search-by-name :numResults="$cats->total()" />
                    </div>

                    @if($cats->total() > 1)
                        <div class="tw-content-block" dusk="sort-options-wrapper">
                            <x-cat-list.sort-links />
                        </div>
                    @endif

                    @if($cats->isNotEmpty() && $cats->total() > \App\Models\Cat::PER_PAGE_12)
                        <div class="tw-content-block" dusk="per_page-options-wrapper">
                            <x-cat-list.per-page-options :cats="$cats" />
                        </div>
                    @endif
                </div>

                <div class="tw-col-span-full lg:tw-col-span-3 xl:tw-col-span-4">
                    {{ $cats->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
