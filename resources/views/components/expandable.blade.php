@props(['title', 'triggerClass' => '', 'iconClass' => ''])

<div
    class="flex justify-between items-center cursor-pointer gap-x-7 select-none {{ $triggerClass }}"
    data-expandable-trigger
>
    <div>{{ $title }}</div>
    <x-icon
        icon="plus"
        class="{{ $iconClass ?? '' }}"
    ></x-icon>
</div>

<div
    class="max-h-0 overflow-hidden transition-all"
    data-expandable-content-state="closed"
>
    <div>{{ $content }}</div>
</div>
