@extends('layouts.app')

@php
    use App\Helpers\AgeFormat;
    use Carbon\Carbon;

    $fallback = '/';

    $dateOfArrivalBoter = $cat->date_of_arrival_boter
        ? $cat->date_of_arrival_boter->format(config('date.format.default'))
        : $fallback;

    $currentAge = $cat->date_of_birth
        ? AgeFormat::formatToAgeString($cat->date_of_birth->diff(Carbon::now()))
        : $fallback;

    $dateOfArrivalMh = $cat->date_of_arrival_mh
        ? strtolower($cat->date_of_arrival_mh->format(config('date.format.month_and_year')))
        : $fallback;

    $ageOnArrivalMh = $cat->date_of_arrival_mh && $cat->date_of_birth
        ? AgeFormat::formatToAgeString($cat->date_of_birth->diff($cat->date_of_arrival_mh))
        : $fallback
@endphp

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">{{ $cat->name }}</h1>

            <figure class="image is-128x128">
                <img class="is-rounded" src="{{ $cat->first_photo_url }}" alt="{{ $cat->name }}">
            </figure>

            <div class="box">
                <div>
                    <span>Datum vstopa v botrstvo:</span>
                    <strong>{{ $dateOfArrivalBoter }}</strong>
                </div>

                <div>
                    <span>Trenutna starost:</span>
                    <strong>{{ $currentAge }}</strong>
                </div>

                <div>
                    <span>Datum prihoda v Mačjo hišo:</span>
                    <strong>{{ $dateOfArrivalMh }}</strong>
                </div>

                <div>
                    <span>Starost ob prihodu:</span>
                    <span>{{ $ageOnArrivalMh }}</span>
                </div>

                <div>
                    <span>Spol:</span>
                    <strong>{{ $cat->gender_label }}</strong>
                </div>
            </div>
        </div>
    </section>
@endsection
