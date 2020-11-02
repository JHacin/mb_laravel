@props(['name', 'label'])

@php
    /** @var string $name */
    $cleanErrorKey = str_replace(['[', ']'], ['.', ''], $name);

    $labelText = $label . ($attributes['required'] ? ' *' : '')
@endphp

<div class="field">
    <label for="{{ $name }}" class="label">{{ $labelText }}</label>

    <div class="control">
        {{ $input }}
    </div>

    @error($cleanErrorKey)<p class="help is-danger">{{ $message }}</p>@enderror

    @isset($help)<p class="help">{{ $help }}</p>@endisset
</div>
