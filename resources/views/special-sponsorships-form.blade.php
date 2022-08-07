@extends('layouts.app')

@php
    use App\Models\SpecialSponsorship;
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
        'sponsorshipTypes' => [
            'options' => SpecialSponsorship::TYPE_LABELS,
            'amounts' => SpecialSponsorship::TYPE_AMOUNTS,
            'default' => $selectedType,
        ],
        'requestUrl' => route('special_sponsorships'),
        'validationConfig' => [
            'monthly_amount_min' => config('money.donation_minimum'),
            'integer_max' => config('validation.integer_max'),
        ],
        'contactEmail' => config('links.contact_email'),
    ];
@endphp

@section('content')
    <div class="mb-container">
        <h1 class="mb-page-title">Dogovor za posebno botrstvo</h1>

        <div id="react-root__special-sponsorship-form" data-props="{{ json_encode($formComponentProps) }}"></div>
    </div>
@endsection

@push('footer-scripts')
    <script src="{{ mix('js/special-sponsorship-form.js') }}"></script>
@endpush
