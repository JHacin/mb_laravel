@props(['title'])

<article class="border-t border-gray-light overflow-hidden">
    <x-expandable>
        <x-slot name="title">
            <h3 class="text-lg font-bold py-4">{{ $title }}</h3>
        </x-slot>
        <x-slot name="content">
            <div class="space-y-2 pb-4">{{ $slot }}</div>
        </x-slot>
    </x-expandable>
</article>
