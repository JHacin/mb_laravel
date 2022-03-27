@props(['title', 'body'])

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-1">
        <div class="text-4xl font-bold">
            {{ $title }}
        </div>
    </div>
    <div class="lg:col-span-2">
        <div class="text-lg space-y-4">
            {{ $body }}
        </div>
    </div>
</div>
