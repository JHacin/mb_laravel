@php
    /** @var string $name */
    $cleanErrorKey = str_replace(['[', ']'], ['.', ''], $name);
@endphp

@error($cleanErrorKey)
    <p class="help is-danger">{{ $message }}</p>
@enderror
