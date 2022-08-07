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
    'validationConfig' => [
        'monthly_amount_min' => config('money.donation_minimum'),
        'integer_max' => config('validation.integer_max'),
    ],
    'contactEmail' => config('links.contact_email'),
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
        <div class="mb-section pt-0 grid grid-cols-1 gap-6 lg:grid-cols-7">
            <div class="lg:col-span-4">
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
            <div class="lg:col-span-3">
                <div
                    id="react-root__cat-sponsor-form"
                    data-props="{{ json_encode($formComponentProps) }}"
                ></div>
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script src="{{ mix('js/cat-sponsor-form.js') }}"></script>
@endpush
