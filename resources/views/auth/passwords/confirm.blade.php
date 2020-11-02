@extends('layouts.app')

@section('meta_title', 'Potrditev gesla | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Potrditev gesla</h1>

            <div>Pred nadaljevanjem prosimo, da potrdite svoje geslo.</div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <x-inputs.password required autocomplete="current-password" />

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">Potrdi</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
