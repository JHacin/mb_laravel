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

                <div class="field">
                    <label class="label" for="email">Email</label>
                    <div class="control has-icons-left">
                        <input
                            class="input @error('email') is-danger @enderror"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email"
                            required
                            autocomplete="email"
                            autofocus
                        >
                        <span class="icon is-small is-left">
                          <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                    @error('email')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

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
