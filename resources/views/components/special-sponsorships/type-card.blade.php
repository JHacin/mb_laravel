@props(['label', 'link', 'description_short', 'description_long'])

{{--  --}}

<div class="space-y-5 pl-5 pr-8 pt-7 pb-8 border-t border-gray-light border-dashed">
    <h3 class="text-2xl font-bold text-primary">
        {{ $label }}
    </h3>
    <div class="text-lg">
        {{ $description_short }}
    </div>
    <div
        class="text-gray-dark relative before:bg-primary before:block before:absolute before:-left-5 before:-translate-x-1/2 before:w-[1px] before:h-full">
        {{ $description_long }}
    </div>
    <div>
        <a
            class="mb-link flex items-center space-x-2 font-semibold"
            href="{{ $link }}"
        >
            <span>Izberi</span>
            <x-icon
                icon="arrow-right"
                class="text-lg"
            ></x-icon>
        </a>
    </div>
</div>
