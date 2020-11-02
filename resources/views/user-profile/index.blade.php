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

                <x-inputs.user-name value="{{ $user->name }}" required />
                <x-inputs.email value="{{ $user->email }}" />
                <x-inputs.password autocomplete="new-password" />
                <x-inputs.password-confirm autocomplete="new-password" />
                <x-inputs.first-name value="{{ $user->personData->first_name }}" />
                <x-inputs.last-name value="{{ $user->personData->last_name }}" />
                <x-inputs.person-gender :selected="$user->personData->gender" />
                <x-inputs.phone value="{{ $user->personData->phone }}" />
                <x-inputs.date-of-birth value="{{ $user->personData->date_of_birth }}" />
                <x-inputs.address value="{{ $user->personData->address }}" />
                <x-inputs.zip-code value="{{ $user->personData->zip_code }}" />
                <x-inputs.city value="{{ $user->personData->city }}" />
                <x-inputs.country :selected="$user->personData->country" />

                <div class="field">
                    <button type="submit" class="button is-primary">{{ trans('forms.confirm') }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection
