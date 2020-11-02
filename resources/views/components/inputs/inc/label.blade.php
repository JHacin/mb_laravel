@php
    use Illuminate\View\ComponentAttributeBag;

    /** @var string $label */
    /** @var ComponentAttributeBag $attributes */
    $labelText = $label . ($attributes['required'] ? ' *' : '')
@endphp

@isset($label)
    <label for="{{ $name }}" class="label">{{ $labelText }}</label>
@endisset
