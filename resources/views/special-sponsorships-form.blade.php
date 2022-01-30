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
    <div class="mb-page-content-container">
        <h1 class="mb-page-title">Dogovor za posebno botrstvo</h1>

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

            <div class="columns">
                <div class="column is-12">
                    <x-inputs.money
                        name="amount"
                        label="{{ trans('special_sponsorship.amount') }}"
                        required
                        min="{{ \App\Models\SpecialSponsorship::TYPE_AMOUNTS[$selectedType] }}"
                        value="{{ \App\Models\SpecialSponsorship::TYPE_AMOUNTS[$selectedType] }}"
                    >
                        <x-slot name="help">Če želite, lahko donirate višji znesek.</x-slot>
                    </x-inputs.money>
                </div>
            </div>

            <hr>

            <x-form-groups.giftee-data />

            <hr>

            <x-form-groups.sponsorship-form-footer />
        </form>
    </div>
@endsection

@push('footer-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            handleTypeChanges();
        });

        function handleTypeChanges() {
            const typeSelect = document.querySelector('select[name="type"]')
            const amountInput = document.querySelector('input[type="number"][name="amount"]')
            const amounts = @json(\App\Models\SpecialSponsorship::TYPE_AMOUNTS);

            typeSelect.addEventListener('change', function(ev) {
                const type = ev.target.value;
                const newMinAmount = amounts[type]

                amountInput.setAttribute('min', newMinAmount);

                if (Number(amountInput.value) < newMinAmount) {
                    amountInput.value = newMinAmount;
                }
            });
        }

    </script>
@endpush
