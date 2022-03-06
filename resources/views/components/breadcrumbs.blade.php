@props(['items'])

<div class="flex items-center flex-wrap gap-x-3 font-mono">
    @foreach ($items as $item)
        @isset($item['link'])
            <a
                href="{{ $item['link'] }}"
                class="mb-link"
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
