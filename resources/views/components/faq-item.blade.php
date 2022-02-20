@props(['title'])

<article class="border-t border-gray-light overflow-hidden">
  <x-expandable>
      <x-slot name="title">
          <h3 class="mb-typography-content-lg mb-font-primary-semibold py-4">{{ $title }}</h3>
      </x-slot>
      <x-slot name="content">
          <div class="mb-typography-content-base space-y-2 pb-4">{{ $slot }}</div>
      </x-slot>
  </x-expandable>
</article>
