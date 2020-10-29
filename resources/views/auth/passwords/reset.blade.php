@extends('layouts.app')

@section('meta_title', 'Sprememba gesla | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Sprememba gesla</h1>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <x-user-email-field value="{{ $email }}" autocomplete="email" autofocus />
                <x-user-password-field label="Novo geslo" required autocomplete="new-password" />
                <x-user-password-confirm-field label="Potrditev novega gesla" required autocomplete="new-password" />

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">Ponastavi geslo</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
