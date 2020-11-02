@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Dogovor o posvojitvi na daljavo</h1>

            <form method="POST" action="{{ route('become_cat_sponsor', $cat) }}">
                @csrf

                <x-inputs.base.input name="personData[first_name]" label="{{ trans('person_data.first_name') }}" />
                <x-inputs.base.input name="personData[last_name]" label="{{ trans('person_data.last_name') }}" />
                <x-inputs.base.input name="personData[address]" label="{{ trans('person_data.address') }}" />
                <x-inputs.base.input name="personData[zip_code]" label="{{ trans('person_data.zip_code') }}" />
                <x-inputs.base.input name="personData[city]" label="{{ trans('person_data.city') }}" />
                <x-inputs.country name="personData[country]" label="{{ trans('person_data.country') }}" />
                <x-inputs.date-of-birth name="personData[date_of_birth]" label="{{ trans('person_data.date_of_birth') }}" />
                <x-inputs.person-gender name="personData[gender]" label="{{ trans('person_data.gender') }}" />
                <x-inputs.base.input name="personData[phone]" label="{{ trans('person_data.phone') }}" />
                <x-inputs.email name="personData[email]" label="{{ trans('user.email') }}" required />

                <x-inputs.money name="monthly_amount" label="{{ trans('sponsorship.monthly_amount') }}" required>
                    <x-slot name="help">
                        Vpišite znesek v €, ki ga želite mesečno nakazovati za vašega posvojenca.
                    </x-slot>
                </x-inputs.money>

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

                <x-inputs.base.checkbox name="is_agreed_to_terms">
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
