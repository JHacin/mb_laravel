@props([
    'src',
    'alt',
])

<figure class="relative pt-[100%]">
    <img
        class="absolute inset-0"
        src="{{ $src }}"
        alt="{{ $alt }}"
    >
</figure>
