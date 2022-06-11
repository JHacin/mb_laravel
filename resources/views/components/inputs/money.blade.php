@php
    use Illuminate\View\ComponentAttributeBag;

    /** @var ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'type' => 'number',
        'min' => '0.00',
        'max' => config('validation.integer_max'),
        'step' => '1',
    ]);
@endphp

@include('components.inputs.base.input')
