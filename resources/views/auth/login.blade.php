@extends('layouts.app')

@section('meta_title', 'Prijava | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Prijava</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                @error('email')
                <div class="notification is-danger">{{ $message }}</div>
                @enderror

                <x-inputs.email
                    name="email"
                    label="{{ trans('user.email') }}"
                    autofocus
                    required
                />
                <x-inputs.password
                    name="password"
                    label="{{ trans('user.password') }}"
                    required
                    autocomplete="current-password"
                />

                <x-inputs.base.checkbox name="remember" label="Zapomni si me" />

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link" dusk="login-form-submit">Prijava</button>
                    </div>
                </div>

                <div class="field">
                    <a href="{{ route('password.request') }}" dusk="login-form-forgot-password">Pozabil/-a sem geslo</a>
                </div>
            </form>
        </div>
    </section>
@endsection
