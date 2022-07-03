@props(['label', 'link', 'description_short', 'description_long', 'thumbnail'])

<div class="flex flex-col shadow-lg rounded overflow-hidden transition-shadow hover:shadow-xl">
    <div>
        <img src="{!! $thumbnail !!}" alt="{{ $label }}" />
    </div>
    <div class="flex-1 flex flex-col p-5">
        <div class="text-2xl font-bold mb-4">{{ $label }}</div>
        <div class="mb-6">{{ $description_short }}</div>
        <div class="mt-auto">
            <a class="mb-btn mb-btn-primary" href="{{ $link }}">
                <span>Izberi</span>
                <x-icon icon="arrow-right" class="text-lg"></x-icon>
            </a>
        </div>
    </div>
    <div
        style="display: none;"
        class="text-gray-dark relative before:bg-primary before:block before:absolute before:-left-5 before:-translate-x-1/2 before:w-[1px] before:h-full">
        {{ $description_long }}
    </div>
</div>
