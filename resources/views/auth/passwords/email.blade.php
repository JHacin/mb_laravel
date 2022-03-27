@extends('layouts.app')

@section('meta_title', 'Ponastavitev gesla | Mačji boter')

@section('content')
    <div class="mb-container">
        <h1 class="mb-page-title">Ponastavitev gesla</h1>

        <form
            method="POST"
            action="{{ route('password.email') }}"
        >
            @csrf

            @if (session('status'))
                <div class="notification is-success">
                    {{ session('status') }}
                </div>
            @endif

            <x-inputs.email
                name="email"
                label="{{ trans('user.email') }}"
                autocomplete="email"
                autofocus
                required
            />

            <div class="field">
                <div class="control">
                    <button
                        type="submit"
                        class="button is-link"
                        dusk="forgot-password-form-submit"
                    >
                        Pošlji navodila za ponastavitev
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
