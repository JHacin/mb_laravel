@extends('layouts.app')

@section('meta_title', 'Registracija | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="mb-page-title">Registracija</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <x-inputs.base.input
                    name="name"
                    label="{{ trans('user.name') }}"
                    autofocus
                    required
                />
                <x-inputs.email
                    name="email"
                    label="{{ trans('user.email') }}"
                    autocomplete="email"
                    required
                />
                <x-inputs.password
                    name="password"
                    label="{{ trans('user.password') }}"
                    required
                    autocomplete="new-password"
                />
                <x-inputs.password
                    name="password_confirmation"
                    label="{{ trans('user.password_confirm') }}"
                    required
                    autocomplete="new-password"
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
