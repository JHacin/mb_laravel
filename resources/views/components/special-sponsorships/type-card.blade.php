@props(['label', 'link', 'description_short', 'description_long'])

<div class="border border-gray-extralight shadow-lg p-4 space-y-4 lg:p-6 lg:space-y-6 xl:p-8 xl:space-y-8">
    <h3 class="mb-typography-content-lg mb-font-primary-bold text-primary">
        {{ $label }}
    </h3>
    <div class="mb-typography-content-base">
        <div class="mb-4">{{ $description_short }}</div>
        <div class="mb-typography-content-base">
            <x-expandable triggerClass="inline-flex pb-2">
                <x-slot name="title">
                    <div class="underline">Več podatkov</div>
                </x-slot>
                <x-slot name="content">
                    <div class="bg-gray-extralight text-gray-dark p-4 shadow space-y-2">
                        {{ $description_long }}
                    </div>
                </x-slot>
            </x-expandable>
        </div>
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
