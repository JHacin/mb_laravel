@extends('layouts.app')

@php
    use App\Models\Cat;
    use App\Utilities\AgeFormat;
    use Carbon\Carbon;

    $fallback = '/';

    /** @var Cat $cat */
    $dateOfArrivalBoter = $cat->date_of_arrival_boter
        ? $cat->date_of_arrival_boter->format(config('date.format.default'))
        : $fallback;

    $currentAge = $cat->date_of_birth
        ? AgeFormat::formatToAgeString($cat->date_of_birth->diff(Carbon::now()))
        : $fallback;

    $dateOfArrivalMh = $cat->date_of_arrival_mh
        ? strtolower($cat->date_of_arrival_mh->translatedFormat(config('date.format.month_and_year')))
        : $fallback;

    $ageOnArrivalMh = $cat->date_of_arrival_mh && $cat->date_of_birth
        ? AgeFormat::formatToAgeString($cat->date_of_birth->diff($cat->date_of_arrival_mh))
        : $fallback
@endphp

@section('content')
    <div class="mb-page-content-container">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:grid-rows-[auto_1fr]">
            <div class="col-span-1 lg:col-start-2">
                <h1 class="mb-page-title">{{ $cat->name }}</h1>
            </div>

            <div class="col-span-1 lg:col-start-1 lg:row-start-1 lg:row-span-2">
                <x-cat-photo
                    src="{{ $cat->first_photo_url }}"
                    alt="{{ $cat->name }}"
                ></x-cat-photo>
            </div>

            <div class="col-span-1 lg:col-start-2">
                <div class="text-lg">
                    [kratek opis] Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                </div>

                @if(!$cat->is_group)
                    <div class="block">
                        <div class="mb-2">
                            <span>Datum vstopa v botrstvo:</span>
                            <strong dusk="cat-details-date_of_arrival_boter">{{ $dateOfArrivalBoter }}</strong>
                        </div>

                        <div class="mb-2">
                            <span>Trenutna starost:</span>
                            <strong dusk="cat-details-current_age">{{ $currentAge }}</strong>
                        </div>

                        <div class="mb-2">
                            <span>Datum prihoda v Mačjo hišo:</span>
                            <strong dusk="cat-details-date_of_arrival_mh">{{ $dateOfArrivalMh }}</strong>
                        </div>

                        <div class="mb-2">
                            <span>Starost ob prihodu:</span>
                            <strong dusk="cat-details-age_on_arrival_mh">{{ $ageOnArrivalMh }}</strong>
                        </div>

                        <div>
                            <span>Spol:</span>
                            <strong dusk="cat-details-gender_label">{{ $cat->gender_label }}</strong>
                        </div>
                    </div>
                @endif

                <div>
                    @if($cat->status === \App\Models\Cat::STATUS_TEMP_NOT_SEEKING_SPONSORS)
                        <em>{{ trans('cat.temp_not_seeking_sponsors_text') }}</em>
                    @else
                        <a
                            class="mb-btn mb-btn-primary"
                            href="{{ route('become_cat_sponsor', $cat) }}"
                            dusk="cat-details-become-sponsor-form-link"
                        >
                            <x-icon icon="arrow-right"></x-icon>
                            <span>{{ $cat->is_group ? 'Postani boter' : 'Postani moj boter' }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div>
            @if(!$cat->is_group)
                <h4>Moja zgodba</h4>
            @endif

            <div>{!! $cat->story !!}</div>
        </div>

        <div>
            <h4>
                @if($cat->is_group)
                    Trenutni botri
                @else
                    Moji botri
                @endif
            </h4>
            <div>
                @if($cat->sponsorships()->count() === 0)
                    Muca še nima botrov.
                @else
                    @foreach($sponsors['identified'] as $sponsor)
                        <x-sponsor-details :sponsor="$sponsor"></x-sponsor-details>
                    @endforeach
                    @if(count($sponsors['anonymous']) > 0)
                        <div>{{ $sponsors['anonymous_count_label'] }}</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
