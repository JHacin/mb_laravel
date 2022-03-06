@props(['label', 'link', 'description_short', 'description_long'])

<div class="border border-gray-extralight shadow-lg p-5 space-y-5">
    <h3 class="text-lg font-extrabold text-primary">
        {{ $label }}
    </h3>
    <div>
        <div class="mb-4">{{ $description_short }}</div>
        <div>
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
            <span>izberi</span>
        </a>
    </div>
</div>
