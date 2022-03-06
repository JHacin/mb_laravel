@extends('layouts.app')

@php
use App\Models\Cat;
use App\Utilities\AgeFormat;
use Carbon\Carbon;

$fallback = '/';

/** @var Cat $cat */
$dateOfArrivalBoter = $cat->date_of_arrival_boter ? $cat->date_of_arrival_boter->format(config('date.format.default')) : $fallback;

$currentAge = $cat->date_of_birth ? AgeFormat::formatToAgeString($cat->date_of_birth->diff(Carbon::now())) : $fallback;

$dateOfArrivalMh = $cat->date_of_arrival_mh ? strtolower($cat->date_of_arrival_mh->translatedFormat(config('date.format.month_and_year'))) : $fallback;

$ageOnArrivalMh = $cat->date_of_arrival_mh && $cat->date_of_birth ? AgeFormat::formatToAgeString($cat->date_of_birth->diff($cat->date_of_arrival_mh)) : $fallback;

$dataPieces = [
    [
        'label' => 'Datum vstopa v botrstvo',
        'value' => $dateOfArrivalBoter,
        'dusk' => 'cat-details-date_of_arrival_boter',
    ],
    [
        'label' => 'Trenutna starost',
        'value' => $currentAge,
        'dusk' => 'cat-details-current_age',
    ],
    [
        'label' => 'Datum prihoda v Mačjo hišo',
        'value' => $dateOfArrivalMh,
        'dusk' => 'cat-details-date_of_arrival_mh',
    ],
    [
        'label' => 'Starost ob prihodu',
        'value' => $ageOnArrivalMh,
        'dusk' => 'cat-details-age_on_arrival_mh',
    ],
    [
        'label' => 'Spol',
        'value' => $cat->gender_label,
        'dusk' => 'cat-details-gender_label',
    ],
];

$breadcrumbItems = [
    [
        'label' => 'muce, ki iščejo botra',
        'link' => route('cat_list'),
    ],
    [
        'label' => $cat->name,
    ],
];
@endphp

@section('content')
    <div class="mb-page-content-container">
        <div class="mb-content-offset-l-10">
            <div class="mb-6">
                <x-breadcrumbs :items="$breadcrumbItems"></x-breadcrumbs>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:grid-rows-[auto_1fr]">
                <div class="col-span-1 lg:col-start-2">
                    <h1 class="mb-page-title">{{ $cat->name }}</h1>
                </div>

                <div class="col-span-1 lg:col-start-1 lg:row-start-1 lg:row-span-2">
                    <x-cat-details.gallery :cat="$cat"></x-cat-details.gallery>
                </div>

                <div class="col-span-1 lg:col-start-2">
                    <div class="mb-page-subtitle">
                        {!! $cat->story_short !!}
                    </div>

                    @if (!$cat->is_group)
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6">
                            @foreach ($dataPieces as $dataPiece)
                                <div class="space-y-1">
                                    <div class="text-primary font-bold">
                                        {{ $dataPiece['label'] }}
                                    </div>
                                    <div dusk="{{ $dataPiece['dusk'] }}">
                                        {{ $dataPiece['value'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-6">
                        @if ($cat->status === \App\Models\Cat::STATUS_TEMP_NOT_SEEKING_SPONSORS)
                            <div class="italic">
                                {{ trans('cat.temp_not_seeking_sponsors_text') }}
                            </div>
                        @else
                            <a
                                class="mb-btn mb-btn-primary"
                                href="{{ route('become_cat_sponsor', $cat) }}"
                                dusk="cat-details-become-sponsor-form-link"
                            >
                                <x-icon icon="arrow-right"></x-icon>
                                <span>{{ $cat->is_group ? 'postani boter' : 'postani moj boter' }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="mb-content-offset-x-12 py-section">
            <div>
                <h4 class="mb-content-section-title mb-6">
                    {{ $cat->is_group ? 'O nas' : 'Moja zgodba' }}
                </h4>

                <div>{!! $cat->story !!}</div>
            </div>

            <div class="pt-section">
                <h4 class="mb-content-section-title mb-6">
                    {{ $cat->is_group ? 'Naši botri' : 'Moji botri' }}
                </h4>

                @if ($cat->sponsorships()->count() === 0)
                    <div>
                        Muca še nima botrov.
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach ($sponsors['identified'] as $sponsor)
                            <x-sponsor-details :sponsor="$sponsor"></x-sponsor-details>
                        @endforeach

                        @if (count($sponsors['anonymous']) > 0)
                            <div>
                                {{ $sponsors['anonymous_count_label'] }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
