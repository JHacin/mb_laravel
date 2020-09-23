@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control has-icons-left has-icons-right">
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
                    <div class="control has-icons-left has-icons-right">
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
                  <i class="fas fa-envelope"></i>
                </span>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">Prijava</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
