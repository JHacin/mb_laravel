@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <div>Pred nadaljevanjem prosimo, da potrdite svoje geslo.</div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="field">
                    <label class="label is-sr-only" for="password">Geslo</label>
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
                        <button type="submit" class="button is-link">Potrdi</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
