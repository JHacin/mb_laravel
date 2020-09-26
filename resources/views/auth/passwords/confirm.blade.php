@extends('layouts.app')

@section('meta_title', 'Potrditev gesla | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Potrditev gesla</h1>

            <div>Pred nadaljevanjem prosimo, da potrdite svoje geslo.</div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="field">
                    <label class="label is-sr-only" for="password">Geslo</label>
                    <div class="control has-icons-left">
                        <input
                            class="input @error('password') is-danger @enderror"
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
                    @error('password')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
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
