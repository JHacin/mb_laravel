@extends('layouts.app')

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

                <x-form-groups.payer-data />

                <div class="columns">
                    <div class="column is-12">
                        <x-inputs.money name="monthly_amount" label="{{ trans('sponsorship.monthly_amount') }}" required>
                            <x-slot name="help">
                                Vpišite znesek v €, ki ga želite mesečno nakazovati za vašega posvojenca.
                                <strong>Minimalno: 5€</strong>
                            </x-slot>
                        </x-inputs.money>
                    </div>
                </div>

                <hr>

                <x-form-groups.giftee-data />

                <hr>

                <div class="block">
                    <span>Ime živali, ki jo želite posvojiti na daljavo:</span>
                    <strong>{{ $cat->name }}</strong>
                    <span>({{ $cat->id }})</span>
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

                <x-form-groups.sponsorship-form-footer />
            </form>
        </div>
    </section>
@endsection
