@php
    use Illuminate\View\ComponentAttributeBag;

    /** @var ComponentAttributeBag $attributes */
    $attributes = $attributes->merge(['type' => 'password']);
@endphp

@include('components.inputs.base.input')
