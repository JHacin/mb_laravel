@props([
    'src',
    'alt',
])

<figure {{ $attributes->merge(['class' => 'relative pt-[100%]']) }}>
    <img
        class="absolute inset-0 w-full"
        src="{{ $src }}"
        alt="{{ $alt }}"
    >
</figure>
