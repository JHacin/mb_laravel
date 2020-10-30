@extends('layouts.app')

@section('meta_title', 'Moj profil | Mačji boter')

@php
    use App\Models\User;

    /** @var User $user */
    $user = Auth::getUser()->loadMissing('personData.sponsorships.cat');
    $sponsorships = $user->personData->sponsorships
@endphp

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Moja botrovanja</h1>
            @if($sponsorships->count() === 0)
                <div>Nimate še botrovanj.</div>
            @else
                @foreach($sponsorships as $sponsorship)
                    <div>
                        <a href="{{ route('cat_details', $sponsorship->cat) }}">
                            {{ $sponsorship->cat->name }}
                        </a>
                    </div>
                @endforeach
            @endif

            <h1 class="title">Moj profil</h1>

            <form method="POST" action="{{ route('user-profile') }}">
                @csrf

                <x-user-name-field value="{{ $user->name }}" />
                <x-user-email-field value="{{ $user->email }}" />
                <x-user-password-field />
                <x-user-password-confirm-field />
                <x-person-data-first-name-field value="{{ $user->personData->first_name }}" />
                <x-person-data-last-name-field value="{{ $user->personData->last_name }}" />
                <x-person-data-gender-field value="{{ $user->personData->gender }}" />
                <x-person-data-phone-field value="{{ $user->personData->phone }}" />
                <x-person-data-date-of-birth-field value="{{ $user->personData->date_of_birth }}" />
                <x-person-data-address-field value="{{ $user->personData->address }}" />
                <x-person-data-zip-code-field value="{{ $user->personData->zip_code }}" />
                <x-person-data-city-field value="{{ $user->personData->city }}" />
                <x-person-data-country-field value="{{ $user->personData->country }}" />

                <div class="field">
                    <button type="submit" class="button is-primary">{{ trans('forms.confirm') }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection
