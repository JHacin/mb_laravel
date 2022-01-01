@extends('layouts.app')

@section('meta_title', 'Sprememba gesla | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <x-page-title text="Sprememba gesla"></x-page-title>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <x-inputs.email
                    name="email"
                    label="{{ trans('user.email') }}"
                    value="{{ $email }}"
                    autocomplete="email"
                    autofocus
                    required
                />

                <x-inputs.password
                    name="password"
                    label="Novo geslo"
                    required
                    autocomplete="new-password"
                />
                <x-inputs.password
                    name="password_confirmation"
                    label="Potrditev novega gesla"
                    required
                    autocomplete="new-password"
                />

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link" dusk="reset-password-form-submit">
                            Ponastavi geslo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
