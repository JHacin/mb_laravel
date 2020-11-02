@props(['selected'])

@php
    use App\Utilities\CountryList;
    $options = CountryList::COUNTRY_NAMES
@endphp

<x-inputs.base.select
    name="personData[country]"
    label="{{ trans('person_data.country') }}"
    :options="$options"
    :selected="$selected"
/>
