@extends('layouts.app')

@section('meta_title', 'Moj profil | Mačji boter')

@php
    use App\Models\User;

    /** @var User $user */
    $user = Auth::user()
@endphp

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Moj profil</h1>

            <form method="POST" action="{{ route('user-profile') }}">
                @csrf

                <x-user-name-field value="{{ $user->name }}" />
                <x-user-email-field value="{{ $user->email }}" />
                <x-user-password-field />
                <x-user-password-confirm-field />

                <div class="field">
                    <button type="submit" class="button is-primary">{{ trans('forms.confirm') }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection
