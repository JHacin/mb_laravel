{{--Todo: disable link functionality if href equals empty string--}}

@if ($paginator->hasPages())
    <nav
      class="flex flex-wrap justify-center md:justify-end gap-x-1 gap-y-2"
      role="navigation"
      aria-label="premikanje po straneh"
    >
        {{-- Previous Page Link --}}
        <a
          @class([
            'mb-pagination-btn',
            'pointer-events-none text-gray-300' => $paginator->onFirstPage()
          ])
          aria-label="@lang('pagination.previous')"
          dusk="pagination-previous"
          @if($paginator->onFirstPage())
            aria-disabled="true"
          @else
            href="{{ $paginator->previousPageUrl() }}"
            rel="prev"
          @endif
        >
            <x-icon icon="chevron-left"></x-icon>
        </a>

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span
                  class="mb-pagination-btn pointer-events-none"
                  aria-disabled="true"
                >&hellip;</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <a
                      @class([
                        'mb-pagination-btn',
                        'bg-primary text-white pointer-events-none' => $page == $paginator->currentPage()
                      ])
                      aria-label="{{ $page == $paginator->currentPage() ? 'Stran '.$page : 'Pojdi na stran'.$page }}"
                      aria-current="{{ $page == $paginator->currentPage() ? 'page' : '' }}"
                      @if($page != $paginator->currentPage())
                      href="{{ $url }}"
                      @endif
                    >{{ $page }}</a>
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        <a
          @class([
            'mb-pagination-btn',
            'pointer-events-none text-gray-300' => !$paginator->hasMorePages()
          ])
          aria-label="@lang('pagination.next')"
          dusk="pagination-next"
          @if($paginator->hasMorePages())
          href="{{ $paginator->nextPageUrl() }}"
          rel="next"
          @else
          aria-disabled="true"
          @endif
        >
            <x-icon icon="chevron-right"></x-icon>
        </a>
    </nav>
@endif
