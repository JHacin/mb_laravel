@props([
    'title',
    'triggerClass' => '',
])

<div
    class="flex justify-between items-center cursor-pointer gap-x-2 select-none {{ $triggerClass }}"
    data-expandable-trigger
>
    <div>{{ $title }}</div>
    <x-icon icon="plus"></x-icon>
</div>

<div
    class="max-h-0 overflow-hidden transition-all"
    data-expandable-content-state="closed"
>
    <div>{{ $content }}</div>
</div>