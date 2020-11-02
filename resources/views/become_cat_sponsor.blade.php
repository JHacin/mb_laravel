@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Dogovor o posvojitvi na daljavo</h1>

            <form method="POST" action="{{ route('become_cat_sponsor', $cat) }}">
                @csrf

                <x-inputs.first-name />
                <x-inputs.last-name />
                <x-inputs.address />
                <x-inputs.zip-code />
                <x-inputs.city />
                <x-inputs.country />
                <x-inputs.date-of-birth />
                <x-inputs.person-gender />
                <x-inputs.phone />
                <x-inputs.email name="personData[email]" required />

                <x-inputs.money name="monthly_amount" label="{{ trans('sponsorship.monthly_amount') }}" required>
                    <x-slot name="help">
                        Vpišite znesek v €, ki ga želite mesečno nakazovati za vašega posvojenca.
                    </x-slot>
                </x-inputs.money>


                <div class="field">
                    <div class="control">
                        <label class="checkbox" for="is_anonymous">
                            <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1">
                            Botrovanje naj bo <strong>anonimno</strong>
                        </label>
                    </div>
                    <p class="help">Označite, če ne želite, da se vaše ime in kraj prikažeta na seznamu botrov
                        meseca.</p>
                </div>

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

                <div class="field">
                    <div class="control">
                        <label class="checkbox" for="is_agreed_to_terms">
                            <input type="checkbox" id="is_agreed_to_terms" name="is_agreed_to_terms">
                            Potrjujem, da sem seznanjen/a s pravili posvojitve na daljavo in se z njimi strinjam ter
                            Mačji hiši dovoljujem rabo osebnih podatkov izključno za namene obveščanja.
                        </label>
                    </div>
                </div>

                <div class="field">
                    <button type="submit" class="button is-primary">
                        Pošlji obrazec
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
