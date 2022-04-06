@props(['items'])

<div class="flex items-center flex-wrap gap-x-3 text-lg">
    @foreach ($items as $item)
        @isset($item['link'])
            <a
                href="{{ $item['link'] }}"
                class="mb-link underline underline-offset-4"
            >
                {{ $item['label'] }}
            </a>
        @else
            <span>
                {{ $item['label'] }}
            </span>
        @endisset

        @if (!$loop->last)
            <span class="w-px h-4 bg-gray-light"></span>
        @endif
    @endforeach
</div>
