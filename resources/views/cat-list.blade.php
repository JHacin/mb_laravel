@php
$showPerPageOptions = $cats->isNotEmpty() && $cats->total() > \App\Models\Cat::PER_PAGE_12;
@endphp

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
                    class="mb-link"
                    dusk="why-become-sponsor-link"
                >tej povezavi</a>.
            </h2>
        </div>

        <div class="mb-content-block">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <x-cat-list.search-by-name :numResults="$cats->total()"></x-cat-list.search-by-name>

                @if ($cats->total() > 1)
                    <div dusk="sort-options-wrapper">
                        <x-cat-list.sort-links></x-cat-list.sort-links>
                    </div>
                @endif
            </div>

            @if (request('search'))
                <div class="mt-1">
                    <x-cat-list.clear-search-link></x-cat-list.clear-search-link>
                </div>
            @endif
        </div>


        <div class="mb-divider"></div>

        <div class="mb-6">
            @if ($cats->isNotEmpty())
                <div
                    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6"
                    dusk="cat-list-items"
                >
                    @foreach ($cats as $cat)
                        <x-cat-list.cat :cat="$cat"></x-cat-list.cat>
                    @endforeach
                </div>
            @else
                <div>Za vaše iskanje ni bilo najdenih rezultatov.</div>
            @endif
        </div>

        <div class="flex flex-col items-center gap-6 lg:flex-row lg:justify-between">
            @if ($showPerPageOptions)
                <div dusk="per_page-options-wrapper">
                    <x-cat-list.per-page-options :cats="$cats"></x-cat-list.per-page-options>
                </div>
            @endif

            <div class="lg:ml-auto">
                {{ $cats->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
