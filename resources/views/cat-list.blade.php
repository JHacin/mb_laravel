@extends('layouts.app')

@section('content')
    <div class="mb-page-content-container">
        <div class="mb-page-header-container">
            <h1 class="mb-page-title">muce, ki iščejo botra</h1>
            <h2 class="mb-page-subtitle">
                Na seznamu so objavljene vse muce, ki trenutno iščejo botra. Če vas zanima več o tem,
                kaj je bistvo programa Mačji boter in kako poteka postopek botrstva, si lahko
                preberete več na
                <a
                    href="{{ route('why_become_sponsor') }}"
                    class="font-semibold"
                    dusk="why-become-sponsor-link"
                >tej povezavi</a>.
            </h2>
        </div>

        <div class="mb-content-block flex items-center justify-between space-x-8">
            <div>
                <x-cat-list.search-by-name :numResults="$cats->total()"></x-cat-list.search-by-name>
            </div>

            @if($cats->total() > 1)
                <div dusk="sort-options-wrapper">
                    <x-cat-list.sort-links></x-cat-list.sort-links>
                </div>
            @endif

            @if($cats->isNotEmpty() && $cats->total() > \App\Models\Cat::PER_PAGE_12)
                <div dusk="per_page-options-wrapper">
                    <x-cat-list.per-page-options :cats="$cats"></x-cat-list.per-page-options>
                </div>
            @endif
        </div>

        <div class="mb-divider"></div>

        <div class="mb-12">
            @if($cats->isNotEmpty())
                <div
                    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6 md:gap-8 xl:gap-10 2xl:gap-12"
                    dusk="cat-list-items"
                >
                    @foreach($cats as $cat)
                        <x-cat-list.cat :cat="$cat"></x-cat-list.cat>
                    @endforeach
                </div>
            @else
                <div>Za vaše iskanje ni bilo najdenih rezultatov.</div>
            @endif
        </div>

        <div>
            {{ $cats->links() }}
        </div>
    </div>
@endsection
