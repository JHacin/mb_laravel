@props(['title'])

<article class="border-t border-gray-light overflow-hidden last:border-b">
    <x-expandable
        triggerClass="text-lg lg:text-xl"
        iconClass="text-primary"
    >
        <x-slot name="title">
            <h3 class="font-bold py-4 text-lg lg:py-5 lg:text-xl">{{ $title }}</h3>
        </x-slot>
        <x-slot name="content">
            <div class="space-y-2 pb-5 lg:pb-6">{{ $slot }}</div>
        </x-slot>
    </x-expandable>
</article>
