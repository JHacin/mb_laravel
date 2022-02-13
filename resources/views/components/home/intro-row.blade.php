@props(['title', 'body'])

<div class="grid gap-6 lg:grid-cols-3 lg:gap-10 xl:gap-16 2xl:gap-24">
    <div class="lg:col-span-1">
        <div class="mb-typography-title-4">
            {{ $title }}
        </div>
    </div>
    <div class="lg:col-span-2">
        <div class="mb-typography-content-base space-y-6">
            {{ $body }}
        </div>
    </div>
</div>
