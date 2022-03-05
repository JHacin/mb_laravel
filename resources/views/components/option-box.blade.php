@props(['label', 'isActive' => false])

<div @class([
    'border rounded py-2 px-5 transition-all',
    'border-gray-light shadow hover:shadow-gray-semi' => !$isActive,
    'bg-gray-light border-transparent' => $isActive,
])>
    <span class="mb-font-primary-semibold">{{ $label }}</span>
</div>
