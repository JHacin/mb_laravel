@php
    use Illuminate\View\ComponentAttributeBag;

    /** @var ComponentAttributeBag $attributes */
    $attributes = $attributes->merge(['type' => 'email']);
@endphp

@include('components.inputs.base.input')
