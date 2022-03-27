@extends('layouts.app')

@section('meta_title', 'Sprememba gesla | Mačji boter')

@section('content')
    <div class="mb-container">
        <h1 class="mb-page-title">Sprememba gesla</h1>

        <form
            method="POST"
            action="{{ route('password.update') }}"
        >
            @csrf

            <input
                type="hidden"
                name="token"
                value="{{ $token }}"
            >

            <x-inputs.email
                name="email"
                label="{{ trans('user.email') }}"
                value="{{ $email }}"
                autocomplete="email"
                autofocus
                required
            />

            <x-inputs.password
                name="password"
                label="Novo geslo"
                required
                autocomplete="new-password"
            />
            <x-inputs.password
                name="password_confirmation"
                label="Potrditev novega gesla"
                required
                autocomplete="new-password"
            />

            <div class="field">
                <div class="control">
                    <button
                        type="submit"
                        class="button is-link"
                        dusk="reset-password-form-submit"
                    >
                        Ponastavi geslo
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
