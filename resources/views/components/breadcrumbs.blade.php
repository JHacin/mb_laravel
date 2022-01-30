@props(['items'])

<div class="flex items-center flex-wrap gap-x-3 mb-6 lg:mb-10">
  @foreach($items as $item)
    @isset($item['link'])
      <a
        href="{{ $item['link'] }}"
        class="mb-link mb-typography-content-sm mb-font-secondary-regular"
      >
        {{ $item['label'] }}
      </a>
    @else
      <span class="mb-typography-content-sm mb-font-secondary-regular">
        {{ $item['label'] }}
      </span>
    @endisset

    @if(!$loop->last)
        <span class="w-px h-4 bg-gray-300"></span>
    @endif
  @endforeach
</div>
