@extends('layouts.app')

@php
    use App\Models\SpecialSponsorship;

    $isGiftRadioOptions = [
        'no' => 'Zame',
        'yes' => 'Darilo',
    ];

    $typeOptions = SpecialSponsorship::TYPE_LABELS;
@endphp

@section('content')
    <div class="section">
        <div class="container mb-6 is-max-desktop">
            <h1 class="title">Dogovor za posebno botrstvo</h1>

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

            <form method="POST" action="{{ route('special_sponsorships_form') }}">
                @csrf

                <div class="columns">
                    <div class="column is-12">
                        <x-inputs.base.select
                            name="type"
                            label="{{ trans('special_sponsorship.type') }}"
                            :options="$typeOptions"
                            :selected="$selectedType"
                        />
                    </div>
                </div>

                <x-form-groups.payer-data />

                <hr>

                <x-form-groups.giftee-data />

                <hr>

                <x-form-groups.sponsorship-form-footer />
            </form>
        </div>
    </div>
@endsection
