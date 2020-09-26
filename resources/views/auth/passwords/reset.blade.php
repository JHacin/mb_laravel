@extends('layouts.app')

@section('meta_title', 'Sprememba gesla | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Sprememba gesla</h1>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control has-icons-left">
                        <input
                            class="input @error('email') is-danger @enderror"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ $email ?? old('email') }}"
                            placeholder="Email"
                            required
                            autocomplete="email"
                            autofocus
                        >
                        <span class="icon is-small is-left">
                          <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                    @error('email')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="password">Novo geslo</label>
                    <div class="control has-icons-left">
                        <input
                            class="input @error('password') is-danger @enderror"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Novo geslo"
                            required
                            autocomplete="new-password"
                        >
                        <span class="icon is-small is-left">
                          <i class="fas fa-key"></i>
                        </span>
                    </div>
                    @error('password')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="password-confirm">Potrditev novega gesla</label>
                    <div class="control has-icons-left">
                        <input
                            class="input @error('password_confirmation') is-danger @enderror"
                            type="password"
                            id="password-confirm"
                            name="password_confirmation"
                            placeholder="Potrditev novega gesla"
                            required
                            autocomplete="new-password"
                        >
                        <span class="icon is-small is-left">
                          <i class="fas fa-key"></i>
                        </span>
                    </div>
                    @error('password_confirmation')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">Ponastavi geslo</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
