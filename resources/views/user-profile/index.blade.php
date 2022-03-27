@extends('layouts.app')

@section('meta_title', 'Moj profil | Mačji boter')

@php
use App\Models\User;

/** @var User $user */
$user = Auth::getUser()->loadMissing('personData.sponsorships.cat');
$sponsorships = $user->personData->sponsorships;
@endphp

@section('content')
    <div class="mb-container">
        @if (session('success_message'))
            <x-notification type="success">
                <x-slot name="message">
                    {{ session('success_message') }}
                </x-slot>
            </x-notification>
        @endif

        <h1 class="mb-page-title">Moja botrstva</h1>

        <div dusk="sponsorship-list">
            @if ($sponsorships->count() === 0)
                <div>Nimate še botrstev.</div>
            @else
                @foreach ($sponsorships as $sponsorship)
                    <div>
                        <a href="{{ route('cat_details', $sponsorship->cat) }}">
                            {{ $sponsorship->cat->name }}
                        </a>
                    </div>
                @endforeach
            @endif
        </div>

        <h1 class="mb-page-title">Moj profil</h1>

        <form
            method="POST"
            action="{{ route('user-profile') }}"
        >
            @csrf

            <x-inputs.base.input
                name="name"
                label="{{ trans('user.name') }}"
                value="{{ $user->name }}"
                required
            />
            <x-inputs.email
                name="email"
                label="{{ trans('user.email') }}"
                value="{{ $user->email }}"
                autocomplete="email"
                required
            />
            <x-inputs.password
                name="password"
                label="{{ trans('user.password') }}"
                autocomplete="new-password"
            />
            <x-inputs.password
                name="password_confirmation"
                label="{{ trans('user.password_confirm') }}"
                autocomplete="new-password"
            />

            <x-inputs.base.input
                name="personData[first_name]"
                label="{{ trans('person_data.first_name') }}"
                value="{{ $user->personData->first_name }}"
            />
            <x-inputs.base.input
                name="personData[last_name]"
                label="{{ trans('person_data.last_name') }}"
                value="{{ $user->personData->last_name }}"
            />
            <x-inputs.person-gender
                name="personData[gender]"
                label="{{ trans('person_data.gender') }}"
                :selected="$user->personData->gender"
            />
            <x-inputs.date-of-birth
                name="personData[date_of_birth]"
                label="{{ trans('person_data.date_of_birth') }}"
                value="{{ $user->personData->date_of_birth }}"
            />
            <x-inputs.base.input
                name="personData[address]"
                label="{{ trans('person_data.address') }}"
                value="{{ $user->personData->address }}"
            />
            <x-inputs.base.input
                name="personData[zip_code]"
                label="{{ trans('person_data.zip_code') }}"
                value="{{ $user->personData->zip_code }}"
            />
            <x-inputs.base.input
                name="personData[city]"
                label="{{ trans('person_data.city') }}"
                value="{{ $user->personData->city }}"
            />
            <x-inputs.country
                name="personData[country]"
                label="{{ trans('person_data.country') }}"
                :selected="$user->personData->country"
            />

            <div class="field">
                <button
                    type="submit"
                    class="button is-primary"
                    dusk="user-profile-form-submit"
                >
                    {{ trans('forms.confirm') }}
                </button>
            </div>
        </form>
    </div>
@endsection
