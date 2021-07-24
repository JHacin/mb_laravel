@extends('layouts.app')

@php
    $isGiftRadioOptions = [
        'no' => 'Zame',
        'yes' => 'Darilo',
    ];
@endphp

@section('content')
    <section class="section">
        <div class="container is-max-desktop">
            <h1 class="title">Dogovor o posvojitvi na daljavo</h1>

            @if(!$errors->isEmpty())
                <x-notification type="danger">
                    <x-slot name="message">
                        Nekatera od polj niso veljavna.
                    </x-slot>
                </x-notification>
            @endif

            @if(session('success_message'))
                <x-notification type="success">
                    <x-slot name="message">
                        {{ session('success_message') }}
                    </x-slot>
                </x-notification>
            @endif

            <form method="POST" action="{{ route('become_cat_sponsor', $cat) }}">
                @csrf

                <div class="columns is-multiline mb-4">
                    <div class="column is-4">
                        <x-inputs.base.input
                            name="personData[first_name]"
                            label="{{ trans('person_data.first_name') }}"
                            required
                        />
                    </div>
                    <div class="column is-5">
                        <x-inputs.base.input
                            name="personData[last_name]"
                            label="{{ trans('person_data.last_name') }}"
                            required
                        />
                    </div>
                    <div class="column is-3">
                        <x-inputs.person-gender
                            name="personData[gender]"
                            label="{{ trans('person_data.gender') }}"
                            wrapperClass="is-fullwidth"
                        />
                    </div>
                    <div class="column is-8">
                        <x-inputs.base.input
                            name="personData[address]"
                            label="{{ trans('person_data.address') }}"
                            required
                        />
                    </div>
                    <div class="column is-4">
                        <x-inputs.base.input
                            name="personData[zip_code]"
                            label="{{ trans('person_data.zip_code') }}"
                            required
                        />
                    </div>
                    <div class="column is-6">
                        <x-inputs.base.input
                            name="personData[city]"
                            label="{{ trans('person_data.city') }}"
                            required
                        />
                    </div>
                    <div class="column is-6">
                        <x-inputs.country
                            name="personData[country]"
                            label="{{ trans('person_data.country') }}"
                            required
                            wrapperClass="is-fullwidth"
                        />
                    </div>
                    <div class="column is-4">
                        <x-inputs.money name="monthly_amount" label="{{ trans('sponsorship.monthly_amount') }}" required>
                            <x-slot name="help">
                                Vpišite znesek v €, ki ga želite mesečno nakazovati za vašega posvojenca.
                                <strong>Minimalno: 5€</strong>
                            </x-slot>
                        </x-inputs.money>
                    </div>
                    <div class="column is-8">
                        <x-inputs.email
                            name="personData[email]"
                            label="{{ trans('user.email') }}"
                            required
                        >
                            <x-slot name="help">
                                Vpišite vaš pravi e-mail naslov, saj vas le tako lahko obveščamo.
                            </x-slot>
                        </x-inputs.email>
                    </div>
                </div>

                <hr>

                <x-inputs.base.radio
                    name="is_gift"
                    :options="$isGiftRadioOptions"
                    checked="no"
                    label="Botrstvo je:"
                    isInline
                />

                <div class="giftee-form has-background-white-ter p-5" style="display: none;">
                    <h3 class="title is-4 has-text-primary">Podatki obdarovanca</h3>

                    <div class="columns is-multiline mb-4">
                        <div class="column is-4">
                            <x-inputs.base.input
                                name="giftee[first_name]"
                                label="{{ trans('person_data.first_name') }}"
                                required
                            />
                        </div>
                        <div class="column is-5">
                            <x-inputs.base.input
                                name="giftee[last_name]"
                                label="{{ trans('person_data.last_name') }}"
                                required
                            />
                        </div>
                        <div class="column is-3">
                            <x-inputs.person-gender
                                name="giftee[gender]"
                                label="{{ trans('person_data.gender') }}"
                                wrapperClass="is-fullwidth"
                            />
                        </div>
                        <div class="column is-8">
                            <x-inputs.base.input
                                name="giftee[address]"
                                label="{{ trans('person_data.address') }}"
                                required
                            />
                        </div>
                        <div class="column is-4">
                            <x-inputs.base.input
                                name="giftee[zip_code]"
                                label="{{ trans('person_data.zip_code') }}"
                                required
                            />
                        </div>
                        <div class="column is-6">
                            <x-inputs.base.input
                                name="giftee[city]"
                                label="{{ trans('person_data.city') }}"
                                required
                            />
                        </div>
                        <div class="column is-6">
                            <x-inputs.country
                                name="giftee[country]"
                                label="{{ trans('person_data.country') }}"
                                required
                                wrapperClass="is-fullwidth"
                            />
                        </div>
                        <div class="column is-12">
                            <x-inputs.email
                                name="giftee[email]"
                                label="{{ trans('user.email') }}"
                                required
                            />
                        </div>
                    </div>
                </div>

                <hr>

                <div class="block">
                    <x-inputs.base.checkbox name="is_anonymous">
                        <x-slot name="label">
                            Botrovanje naj bo <strong>anonimno</strong>
                        </x-slot>
                        <x-slot name="help">
                            Označite, če ne želite, da se vaše ime in kraj prikažeta na seznamu botrov.
                        </x-slot>
                    </x-inputs.base.checkbox>
                </div>


                <div class="block">
                    <x-inputs.base.checkbox name="wants_direct_debit">
                        <x-slot name="label">
                            Želim, da mi pošljete informacije v zvezi z ureditvijo trajnika
                        </x-slot>
                        <x-slot name="help">
                            Navodila boste prejeli na email naslov.
                        </x-slot>
                    </x-inputs.base.checkbox>
                </div>

                <div class="block">
                    <span>Ime živali, ki jo želite posvojiti na daljavo:</span>
                    <strong>{{ $cat->name }}</strong>
                    <span>({{ $cat->id }})</span>
                </div>

                <div class="block">
                    Po oddaji obrazca boste na svoj mail prejeli samodejni odgovor s podatki za nakazilo.
                    Prosimo, preverite tudi nezaželeno pošto in kategorijo Promocije. V primeru, da sporočila ne
                    prejmete, nam pišite na boter@macjahisa.si.
                </div>

                <div class="block">
                    <x-inputs.base.checkbox name="is_agreed_to_terms" required>
                        <x-slot name="label">
                            Potrjujem, da sem seznanjen/a s pravili posvojitve na daljavo in se z njimi strinjam ter
                            Mačji hiši dovoljujem rabo osebnih podatkov izključno za namene obveščanja.
                        </x-slot>
                    </x-inputs.base.checkbox>
                </div>

                <div class="field">
                    <button type="submit" class="button is-primary is-medium" dusk="cat-sponsorship-submit">
                        Pošlji obrazec
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('footer-scripts')
    <script src="{{ mix('js/become_sponsor_form.js') }}"></script>
@endpush
