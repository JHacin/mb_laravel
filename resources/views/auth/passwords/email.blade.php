@extends('layouts.app')

@section('meta_title', 'Ponastavitev gesla | Mačji boter')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Ponastavitev gesla</h1>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                @if (session('status'))
                    <div class="notification is-success">
                        {{ session('status') }}
                    </div>
                @endif

                <x-inputs.email autocomplete="email" autofocus />

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">
                            Pošlji navodila za ponastavitev
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
