@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <form method="POST" action="{{ route('register') }}">
                @csrf
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
                            autocomplete="new-password"
                        >
                        <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
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
