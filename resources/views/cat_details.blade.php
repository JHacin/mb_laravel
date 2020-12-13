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
        <div class="container">
            <h1 class="title" dusk="cat-details-name">{{ $cat->name }}</h1>

            <figure class="image is-128x128">
                <img
                    class="is-rounded"
                    src="{{ $cat->first_photo_url }}"
                    alt="{{ $cat->name }}"
                    dusk="cat-details-photo"
                >
            </figure>

            <div class="box">
                <div>
                    <span>Datum vstopa v botrstvo:</span>
                    <strong dusk="cat-details-date_of_arrival_boter">{{ $dateOfArrivalBoter }}</strong>
                </div>

                <div>
                    <span>Trenutna starost:</span>
                    <strong dusk="cat-details-current_age">{{ $currentAge }}</strong>
                </div>

                <div>
                    <span>Datum prihoda v Mačjo hišo:</span>
                    <strong dusk="cat-details-date_of_arrival_mh">{{ $dateOfArrivalMh }}</strong>
                </div>

                <div>
                    <span>Starost ob prihodu:</span>
                    <span dusk="cat-details-age_on_arrival_mh">{{ $ageOnArrivalMh }}</span>
                </div>

                <div>
                    <span>Spol:</span>
                    <strong dusk="cat-details-gender_label">{{ $cat->gender_label }}</strong>
                </div>
            </div>

            <a
                class="button is-primary"
                href="{{ route('become_cat_sponsor', $cat) }}"
                dusk="cat-details-become-sponsor-form-link"
            >
                Postani moj boter
            </a>

            <h4 class="title is-4">Moja zgodba</h4>

            <div class="content" dusk="cat-details-story">
                {!! $cat->story !!}
            </div>

            <h5 class="title is-5">Moji botri</h5>
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
    </section>
@endsection
