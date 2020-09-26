@extends('layouts.app')

@section('meta_title', 'Registracija | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Registracija</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="field">
                    <label class="label" for="name">Uporabniško ime</label>
                    <div class="control has-icons-left">
                        <input
                            class="input @error('name') is-danger @enderror"
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Uporabniško ime"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            autofocus
                        >
                        <span class="icon is-small is-left">
                          <i class="fas fa-user"></i>
                        </span>
                    </div>
                    @error('name')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control has-icons-left">
                        <input
                            class="input @error('email') is-danger @enderror"
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
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
                    <label class="label" for="password">Geslo</label>
                    <div class="control has-icons-left">
                        <input
                            class="input @error('password') is-danger @enderror"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Geslo"
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
                    <label class="label" for="password-confirm">Potrditev gesla</label>
                    <div class="control has-icons-left">
                        <input
                            class="input @error('password_confirmation') is-danger @enderror"
                            type="password"
                            id="password-confirm"
                            name="password_confirmation"
                            placeholder="Potrditev gesla"
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
                        <button type="submit" class="button is-link">Ustvari račun</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
