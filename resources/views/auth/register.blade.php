@extends('layouts.app')

@section('meta_title', 'Registracija | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Registracija</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <x-inputs.user-name autocomplete="name" autofocus required />
                <x-inputs.email autocomplete="email" autofocus />
                <x-inputs.password required autocomplete="new-password" />
                <x-inputs.password-confirm required autocomplete="new-password" />

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">Ustvari račun</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
