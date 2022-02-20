@props(['label', 'link'])

<div class="border border-gray-extralight shadow-lg p-4 space-y-4 lg:p-6 lg:space-y-6 xl:p-8 xl:space-y-8">
    <h3 class="mb-typography-content-lg mb-font-primary-bold text-primary">
        {{ $label }}
    </h3>
    <div class="mb-typography-content-base">
        {{ $description_short }}
    </div>
    <div>
        <a
            class="mb-btn mb-btn-primary"
            href="{{ $link }}"
        >
            <x-icon icon="arrow-right"></x-icon>
            <span>Izberi</span>
        </a>
    </div>
</div>
