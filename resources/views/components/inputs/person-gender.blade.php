@props(['selected' => \App\Models\PersonData::GENDER_UNKNOWN ])

@php
    use App\Models\PersonData;
    $options = PersonData::GENDER_LABELS
@endphp

<x-inputs.base.select
    name="personData[gender]"
    label="{{ trans('person_data.gender') }}"
    :options="$options"
    :selected="$selected"
/>

