@props(['date', 'title' => '', 'body'])

<div class="pb-6 border-b border-dashed border-gray-light">
    <div class="mb-2 space-y-1">
        <div class="text-sm text-gray-semi">{{ $date }}</div>
        <div class="text-lg font-bold">{{ $title }}</div>
    </div>
    <div>{{ $body }}</div>
</div>
