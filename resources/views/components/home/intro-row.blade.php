@props(['title', 'body'])

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-1">
        <div class="text-xl font-extrabold">
            {{ $title }}
        </div>
    </div>
    <div class="lg:col-span-2">
        <div class="space-y-6">
            {{ $body }}
        </div>
    </div>
</div>
