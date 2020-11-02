@php
    use App\Utilities\CountryList;

    $options = CountryList::COUNTRY_NAMES;
    $selected = $selected ?? CountryList::DEFAULT;
@endphp

@include('components.inputs.base.select', ['options' => $options, 'selected' => $selected])
