@props([
    'date',
    'title' => '',
    'body'
])

<div class="pb-6 border-b border-gray-200">
  <div class="mb-3 space-y-2">
    <div class="text-sm font-mono">{{ $date }}</div>
    <div class="text-2xl font-bold">{{ $title }}</div>
  </div>
  <div>{{ $body }}</div>
</div>
