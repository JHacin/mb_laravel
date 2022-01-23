@props([
    'date',
    'title' => '',
    'body'
])

<div class="pb-6 border-b border-gray-200">
  <div class="mb-2 space-y-1">
    <div class="mb-typography-content-sm mb-font-secondary-regular">{{ $date }}</div>
    <div class="mb-typography-content-lg mb-font-primary-semibold">{{ $title }}</div>
  </div>
  <div class="mb-typography-content-base">{{ $body }}</div>
</div>
