@extends('layouts.app')

@section('meta_title', 'Registracija | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Registracija</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <x-inputs.base.input
                    name="name"
                    label="{{ trans('user.name') }}"
                    autofocus
                    required
                    dusk="register-form-name-input"
                    wrapperDusk="register-form-name-input-wrapper"
                />
                <x-inputs.email
                    name="email"
                    label="{{ trans('user.email') }}"
                    autocomplete="email"
                    required
                    dusk="register-form-email-input"
                    wrapperDusk="register-form-email-input-wrapper"
                />
                <x-inputs.password
                    name="password"
                    label="{{ trans('user.password') }}"
                    required
                    autocomplete="new-password"
                    dusk="register-form-password-input"
                    wrapperDusk="register-form-password-input-wrapper"
                />
                <x-inputs.password
                    name="password_confirmation"
                    label="{{ trans('user.password_confirm') }}"
                    required
                    autocomplete="new-password"
                    dusk="register-form-password-confirm-input"
                    wrapperDusk="register-form-password-confirm-input-wrapper"
                />

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link" dusk="register-form-submit">Ustvari račun</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
