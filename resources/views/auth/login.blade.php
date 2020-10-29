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

                <x-user-email-field autocomplete="email" autofocus />
                <x-user-password-field required autocomplete="current-password" />

                <div class="field">
                    <div class="control">
                        <label class="checkbox">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            Zapomni si me
                        </label>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">Prijava</button>
                    </div>
                </div>

                <div class="field">
                    <a href="{{ route('password.request') }}">Pozabil/-a sem geslo</a>
                </div>
            </form>
        </div>
    </section>
@endsection
