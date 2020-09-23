@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="field">
                    <label class="label" for="name">Uporabniško ime</label>
                    <div class="control has-icons-left has-icons-right">
                        <input
                            class="input"
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
                </div>

                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input
                            class="input"
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
                </div>

                <div class="field">
                    <label class="label" for="password">Geslo</label>
                    <div class="control has-icons-left has-icons-right">
                        <input
                            class="input"
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
                </div>

                <div class="field">
                    <label class="label" for="password-confirm">Potrditev gesla</label>
                    <div class="control has-icons-left has-icons-right">
                        <input
                            class="input"
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
