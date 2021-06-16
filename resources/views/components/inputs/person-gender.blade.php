@php
    use App\Models\PersonData;
    use Illuminate\View\ComponentAttributeBag;

    $options = PersonData::GENDER_LABELS;
    /** @var ComponentAttributeBag $attributes */
    $attributes = $attributes->merge(['required' => 'required'])
@endphp

@include('components.inputs.base.select', [
    'options' => $options,
    'selected' => $selected ?? null,
    'isEmptyDefault' => true,
])
