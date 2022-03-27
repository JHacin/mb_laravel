@props(['title'])

<article class="border-t border-gray-light overflow-hidden">
    <x-expandable triggerClass="text-lg lg:text-xl">
        <x-slot name="title">
            <h3 class="text-lg font-bold py-4 lg:py-5 lg:text-xl">{{ $title }}</h3>
        </x-slot>
        <x-slot name="content">
            <div class="space-y-2 pb-5 lg:pb-6">{{ $slot }}</div>
        </x-slot>
    </x-expandable>
</article>
