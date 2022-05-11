@extends('layouts.app')

@php
use App\Utilities\CountryList;
use App\Models\PersonData;

$formComponentProps = [
    'countryList' => [
        'options' => CountryList::COUNTRY_NAMES,
        'default' => CountryList::DEFAULT,
    ],
    'gender' => [
        'options' => PersonData::GENDER_LABELS,
        'default' => PersonData::GENDER_FEMALE,
    ],
    'requestUrl' => route('become_cat_sponsor', $cat),
];

$breadcrumbItems = [
    [
        'label' => 'muce, ki iščejo botra',
        'link' => route('cat_list'),
    ],
    [
        'label' => $cat->name,
        'link' => route('cat_details', $cat),
    ],
    [
        'label' => 'Dogovor o posvojitvi na daljavo',
    ],
];
@endphp

@section('content')
    <div class="mb-container max-w-7xl">
        <div class="mt-8 mb-6">
            <x-breadcrumbs :items="$breadcrumbItems"></x-breadcrumbs>
        </div>
        <div class="mb-section pt-0 grid grid-cols-1 gap-6 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <x-cat-photo
                    src="{{ $cat->first_photo_url }}"
                    alt="{{ $cat->name }}"
                ></x-cat-photo>

                <div class="mt-6 space-y-4 bg-gray-extralight p-5">
                    <div>
                        Hvala vam, ker ste se odločili za sklenitev botrstva.
                        Z vašo pomočjo lahko mucam omogočimo varno in zadovoljno življenje.
                    </div>
                    <div>
                        Več o razlogih za botrovanje si lahko preberete na
                        <a
                            href="{{ route('why_become_sponsor') }}"
                            class="mb-link"
                        >tej povezavi</a>.
                    </div>
                    <div>
                        Če vas glede postopka botrovanja še kar koli zanima, nam lahko pišete na naslov
                        <a
                            class="mb-link"
                            href="mailto:{{ config('links.contact_email') }}"
                        >{{ config('links.contact_email') }}</a>.
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <div
                    id="react-root__cat-sponsor-form"
                    data-props="{{ json_encode($formComponentProps) }}"
                ></div>
            </div>
        </div>



        {{-- <div class="grid grid-cols-5"> --}}
        {{-- <div class="mb-section pt-0 col-span-full lg:col-span-3"> --}}
        {{-- <div --}}
        {{-- id="react-root__cat-sponsor-form" --}}
        {{-- data-props="{{ json_encode($formComponentProps) }}" --}}
        {{-- ></div> --}}
        {{-- </div> --}}
        {{-- </div> --}}


        {{-- @if (!$errors->isEmpty()) --}}
        {{-- <x-notification type="danger"> --}}
        {{-- <x-slot name="message"> --}}
        {{-- Nekatera od polj niso veljavna. --}}
        {{-- </x-slot> --}}
        {{-- </x-notification> --}}
        {{-- @endif --}}

        {{-- @if (session('success_message')) --}}
        {{-- <x-notification type="success"> --}}
        {{-- <x-slot name="message"> --}}
        {{-- {{ session('success_message') }} --}}
        {{-- </x-slot> --}}
        {{-- </x-notification> --}}
        {{-- @endif --}}

        {{-- <form --}}
        {{-- method="POST" --}}
        {{-- action="{{ route('become_cat_sponsor', $cat) }}" --}}
        {{-- > --}}
        {{-- @csrf --}}

        {{-- <x-form-groups.payer-data /> --}}

        {{-- <div class="columns"> --}}
        {{-- <div class="column is-12"> --}}
        {{-- <x-inputs.money --}}
        {{-- name="monthly_amount" --}}
        {{-- label="{{ trans('sponsorship.monthly_amount') }}" --}}
        {{-- required --}}
        {{-- > --}}
        {{-- <x-slot name="help"> --}}
        {{-- Vpišite znesek v €, ki ga želite mesečno nakazovati za vašega posvojenca. --}}
        {{-- <strong>Minimalno: 5€</strong> --}}
        {{-- </x-slot> --}}
        {{-- </x-inputs.money> --}}
        {{-- </div> --}}
        {{-- </div> --}}

        {{-- <hr> --}}

        {{-- <x-form-groups.giftee-data /> --}}

        {{-- <hr> --}}

        {{-- <div class="block"> --}}
        {{-- <span>Ime živali, ki jo želite posvojiti na daljavo:</span> --}}
        {{-- <strong>{{ $cat->name }}</strong> --}}
        {{-- <span>({{ $cat->id }})</span> --}}
        {{-- </div> --}}

        {{-- <div class="block"> --}}
        {{-- <x-inputs.base.checkbox name="wants_direct_debit"> --}}
        {{-- <x-slot name="label"> --}}
        {{-- Želim, da mi pošljete informacije v zvezi z ureditvijo trajnika --}}
        {{-- </x-slot> --}}
        {{-- <x-slot name="help"> --}}
        {{-- Navodila boste prejeli na email naslov. --}}
        {{-- </x-slot> --}}
        {{-- </x-inputs.base.checkbox> --}}
        {{-- </div> --}}

        {{-- <x-form-groups.sponsorship-form-footer /> --}}
        {{-- </form> --}}
    </div>
@endsection

@push('footer-scripts')
    <script src="{{ mix('js/cat-sponsor-form.js') }}"></script>
@endpush
