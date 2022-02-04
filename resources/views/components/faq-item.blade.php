@props(['title'])

<article class="border-t border-gray-light overflow-hidden">
  <div
    class="flex justify-between items-center cursor-pointer gap-x-4 py-4"
    data-accordion-trigger
  >
    <h3 class="mb-typography-content-lg mb-font-primary-semibold">{{ $title }}</h3>
    <x-icon icon="plus"></x-icon>
  </div>

  <div
    class="max-h-0 transition-all"
    data-accordion-content-state="closed"
  >
    <div class="mb-typography-content-base space-y-2 pb-4">{{ $slot }}</div>
  </div>
</article>
