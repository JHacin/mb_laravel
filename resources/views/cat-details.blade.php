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
    <section class="section">
        <div class="container is-fluid">
            <div class="columns">
                <div class="column is-3">
                    @foreach(\App\Services\CatPhotoService::INDICES as $index)
                        @if($cat->getPhotoByIndex($index) !== null)
                            <figure class="image is-square mb-4">
                                <img
                                    src="{{ $cat->getPhotoByIndex($index)->url }}"
                                    alt="{{ $cat->name }}"
                                    dusk="cat-details-photo-{{ $index }}"
                                >
                            </figure>
                        @endif
                    @endforeach
                </div>

                <div class="column is-6">
                    <h1 class="title" dusk="cat-details-name">{{ $cat->name }}</h1>

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

                    <div class="block">
                        @if($cat->status === \App\Models\Cat::STATUS_TEMP_NOT_SEEKING_SPONSORS)
                            <em>{{ trans('cat.temp_not_seeking_sponsors_text') }}</em>
                        @else
                            <a
                                class="button is-primary is-medium"
                                href="{{ route('become_cat_sponsor', $cat) }}"
                                dusk="cat-details-become-sponsor-form-link"
                            >
                            <span class="icon">
                                <i class="fas fa-arrow-circle-right"></i>
                            </span>
                                <span>
                                @if($cat->is_group)
                                        Postani boter
                                    @else
                                        Postani moj boter
                                    @endif
                            </span>
                            </a>
                        @endif
                    </div>

                    @if(!$cat->is_group)
                        <h4 class="title is-5 mb-3" dusk="cat-details-story-title">Moja zgodba</h4>
                    @endif

                    <div class="content" dusk="cat-details-story">
                        {!! $cat->story !!}
                    </div>
                </div>

                <div class="column is-3">
                    <h5 class="title is-5" dusk="cat-details-sponsor-list-title">
                        @if($cat->is_group)
                            Trenutni botri
                        @else
                            Moji botri
                        @endif
                    </h5>
                    <div dusk="cat-details-sponsor-list">
                        @if($cat->sponsorships()->count() === 0)
                            Muca še nima botrov.
                        @else
                            @foreach($sponsors['identified'] as $sponsor)
                                <x-sponsor-details :sponsor="$sponsor"/>
                            @endforeach
                            @if(count($sponsors['anonymous']) > 0)
                                <div>{{ $sponsors['anonymous_count_label'] }}</div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
