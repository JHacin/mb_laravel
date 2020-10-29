@extends('layouts.app')

@section('meta_title', 'Registracija | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Registracija</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <x-user-name-field autocomplete="name" autofocus />
                <x-user-email-field autocomplete="email" autofocus />
                <x-user-password-field required autocomplete="new-password" />
                <x-user-password-confirm-field required autocomplete="new-password" />

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">Ustvari račun</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
