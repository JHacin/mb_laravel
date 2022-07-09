@props(['label', 'link', 'description', 'details', 'thumbnail'])

<div
        class="flex flex-col shadow-lg overflow-hidden transition-shadow hover:shadow-xl"
        data-ss-card
>
    <div class="relative flex-1">
        <div>
            <img src="{!! $thumbnail !!}" alt="{{ $label }}"/>
        </div>
        <div class="p-5">
            <div class="text-2xl font-bold mb-4">{{ $label }}</div>
            <div class="mb-4">{{ $description }}</div>
            <div>
                <button class="text-primary space-x-1" data-ss-card-details-trigger>
                    <x-icon icon="question"></x-icon>
                    <span>Več o programu</span>
                </button>
            </div>

            <div
                    class="absolute inset-0 w-full bg-gray-extralight transition-transform flex flex-col -translate-x-full"
                    data-ss-card-details
            >
                <div class="p-5 flex-1 overflow-auto">
                    <div class="space-y-6">
                        <div class="text-gray-semi">
                            <div class="text-2xl font-bold mb-4">{{ $label }}</div>
                            <div class="mb-4">{{ $description }}</div>
                        </div>
                        {{ $details }}
                    </div>
                </div>

                <div class="px-5 py-4">
                    <button data-ss-card-details-close class="text-xl">
                        <x-icon icon="arrow-left"></x-icon>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="p-5">
        <a class="mb-btn mb-btn-primary" href="{{ $link }}">
            <span>Izberi</span>
            <x-icon icon="arrow-right" class="text-lg"></x-icon>
        </a>
    </div>
</div>

@pushonce('footer-scripts')
    <script src="{{ mix('js/special-sponsorship-card.js') }}"></script>
@endpushonce
