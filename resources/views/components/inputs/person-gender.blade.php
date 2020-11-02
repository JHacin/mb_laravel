@php
    use App\Models\PersonData;

    $options = PersonData::GENDER_LABELS;
    $selected = $selected ?? PersonData::GENDER_UNKNOWN;
@endphp

@include('components.inputs.base.select', ['options' => $options, 'selected' => $selected])
