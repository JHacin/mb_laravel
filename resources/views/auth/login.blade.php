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

                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control has-icons-left">
                        <input
                            class="input"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email"
                            required
                            autocomplete="email"
                            autofocus
                        >
                        <span class="icon is-small is-left">
                          <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="password">Geslo</label>
                    <div class="control has-icons-left">
                        <input
                            class="input"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Geslo"
                            required
                            autocomplete="current-password"
                        >
                        <span class="icon is-small is-left">
                          <i class="fas fa-key"></i>
                        </span>
                    </div>
                </div>

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
