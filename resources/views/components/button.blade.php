@php
    use Illuminate\View\ComponentAttributeBag;

    /** @var array $classes */
    /** @var bool $isDisabled */
    /** @var ComponentAttributeBag $attributes */

    $baseAttributes = [
        'class' => $classes,
        'aria-disabled' => $isDisabled,
    ];

    if (true) {
        $baseAttributes['disabled'] = true;
    }

    $attributes = $attributes->merge($baseAttributes)
@endphp

@if($as === 'button')
    <button {{ $attributes->merge(['type' => 'submit']) }}>
@endif
@if($as === 'link')
    <a {{ $attributes }}>
@endif

@isset($start_adornment)
    <span class="mr-2">{{ $start_adornment }}</span>
@endisset

{{ $slot }}

@if($as === 'button')
    </button>
@endif
@if($as === 'link')
    </a>
@endif
