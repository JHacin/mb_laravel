@extends('layouts.app')

@section('meta_title', 'Profil | Mačji boter')

@php
    use App\Models\User;

    /** @var User $user */
    $user = Auth::user()
@endphp

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Moj profil</h1>

            <form method="POST" action="{{ route('user-profile') }}">
                @csrf

                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="field">
                    <label for="name" class="label">{{ trans('user.name') }}*</label>
                    <div class="control">
                        <input
                            name="name"
                            id="name"
                            class="input @error('name') is-danger @enderror"
                            type="text"
                            placeholder="{{ trans('user.name') }}"
                            value="{{ old('name') ?? $user->name }}"
                        >
                    </div>
                    @error('name')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="email" class="label">{{ trans('user.email') }}*</label>
                    <div class="control">
                        <input
                            name="email"
                            id="email"
                            class="input @error('email') is-danger @enderror"
                            type="text"
                            placeholder="{{ trans('user.email') }}"
                            value="{{ old('email') ?? $user->email }}"
                        >
                    </div>
                    @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="password">{{ trans('user.password') }}</label>
                    <div class="control">
                        <input
                            class="input @error('password') is-danger @enderror"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="{{ trans('user.password') }}"
                            autocomplete="new-password"
                        >
                    </div>
                    @error('password')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="password-confirm">{{ trans('user.password_confirm') }}</label>
                    <div class="control">
                        <input
                            class="input @error('password_confirmation') is-danger @enderror"
                            type="password"
                            id="password-confirm"
                            name="password_confirmation"
                            placeholder="{{ trans('user.password_confirm') }}"
                            autocomplete="new-password"
                        >
                    </div>
                    @error('password_confirmation')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <button type="submit" class="button is-primary">Potrdi</button>
                </div>
            </form>
        </div>
    </section>
@endsection
