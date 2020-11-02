@extends('layouts.app')

@php
    $user = Auth::check() ? Auth::getUser()->loadMissing('personData') : null;
@endphp

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Dogovor o posvojitvi na daljavo</h1>

            @if (session('success_message'))
                <x-notification type="success">
                    <x-slot name="message">
                        {{ session('success_message') }}
                    </x-slot>
                </x-notification>
            @else
                @auth
                    <x-notification type="warning">
                        <x-slot name="message">
                            <strong>Pozor</strong>: vse spremembe osebnih podatkov bodo shranjene v vašem profilu.
                        </x-slot>
                    </x-notification>
                @endauth
            @endif

            <form method="POST" action="{{ route('become_cat_sponsor', $cat) }}">
                @csrf

                <x-inputs.email
                    name="personData[email]"
                    label="{{ trans('user.email') }}"
                    required
                    value="{{ $user->email ?? '' }}"
                />

                <x-inputs.money name="monthly_amount" label="{{ trans('sponsorship.monthly_amount') }}" required>
                    <x-slot name="help">
                        Vpišite znesek v €, ki ga želite mesečno nakazovati za vašega posvojenca.
                    </x-slot>
                </x-inputs.money>

                <x-inputs.base.input
                    name="personData[first_name]"
                    label="{{ trans('person_data.first_name') }}"
                    value="{{ $user->personData->first_name ?? '' }}"
                />
                <x-inputs.base.input
                    name="personData[last_name]"
                    label="{{ trans('person_data.last_name') }}"
                    value="{{ $user->personData->last_name ?? '' }}"
                />
                <x-inputs.base.input
                    name="personData[address]"
                    label="{{ trans('person_data.address') }}"
                    value="{{ $user->personData->address ?? '' }}"
                />
                <x-inputs.base.input
                    name="personData[zip_code]"
                    label="{{ trans('person_data.zip_code') }}"
                    value="{{ $user->personData->zip_code ?? '' }}"
                />
                <x-inputs.base.input
                    name="personData[city]"
                    label="{{ trans('person_data.city') }}"
                    value="{{ $user->personData->city ?? '' }}"
                />
                <x-inputs.country
                    name="personData[country]"
                    label="{{ trans('person_data.country') }}"
                    :selected="$user->personData->country ?? null"
                />
                <x-inputs.date-of-birth
                    name="personData[date_of_birth]"
                    label="{{ trans('person_data.date_of_birth') }}"
                    value="{{ $user->personData->date_of_birth ?? '' }}"
                />
                <x-inputs.person-gender
                    name="personData[gender]"
                    label="{{ trans('person_data.gender') }}"
                    :selected="$user->personData->gender ?? null"
                />
                <x-inputs.base.input
                    name="personData[phone]"
                    label="{{ trans('person_data.phone') }}"
                    value="{{ $user->personData->phone ?? '' }}"
                />

                <x-inputs.base.checkbox name="is_anonymous">
                    <x-slot name="label">
                        Botrovanje naj bo <strong>anonimno</strong>
                    </x-slot>
                    <x-slot name="help">
                        Označite, če ne želite, da se vaše ime in kraj prikažeta na seznamu botrov.
                    </x-slot>
                </x-inputs.base.checkbox>

                <div class="content">
                    <p>
                        <span>Ime živali, ki jo želite posvojiti na daljavo:</span>
                        <strong>{{ $cat->name }}</strong>
                        <span>({{ $cat->id }})</span>
                    </p>

                    <p>
                        Po oddaji obrazca boste na svoj mail prejeli samodejni odgovor s podatki za nakazilo.
                        Prosimo, preverite tudi nezaželeno pošto in kategorijo Promocije. V primeru, da sporočila ne
                        prejmete, nam pišite na boter@macjahisa.si.
                    </p>
                </div>

                <x-inputs.base.checkbox name="is_agreed_to_terms" required>
                    <x-slot name="label">
                        Potrjujem, da sem seznanjen/a s pravili posvojitve na daljavo in se z njimi strinjam ter
                        Mačji hiši dovoljujem rabo osebnih podatkov izključno za namene obveščanja.
                    </x-slot>
                </x-inputs.base.checkbox>

                <div class="field">
                    <button type="submit" class="button is-primary">
                        Pošlji obrazec
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
