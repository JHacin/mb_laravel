{{--Todo: disable link functionality if href equals empty string--}}

@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="premikanje po straneh">
        {{-- Previous Page Link --}}
        <a
          class="mb-btn pagination-previous"
          aria-label="@lang('pagination.previous')"
          dusk="pagination-previous"
          @if($paginator->onFirstPage())
            disabled
            aria-disabled="true"
          @else
            href="{{ $paginator->previousPageUrl() }}"
            rel="prev"
          @endif
        >
            @lang('pagination.previous')
        </a>

        {{-- Next Page Link --}}
        <a
          class="mb-btn pagination-next"
          aria-label="@lang('pagination.next')"
          dusk="pagination-next"
          @if($paginator->hasMorePages())
            href="{{ $paginator->nextPageUrl() }}"
            rel="next"
          @else
            disabled
            aria-disabled="true"
          @endif
        >
            @lang('pagination.next')
        </a>

        <ul class="pagination-list">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="pagination-ellipsis" aria-disabled="true">&hellip;</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            <a
                              class="mb-btn pagination-link {{ $page == $paginator->currentPage() ? 'pagination-link--is-current' : '' }}"
                              aria-label="{{ $page == $paginator->currentPage() ? 'Stran '.$page : 'Pojdi na stran'.$page }}"
                              aria-current="{{ $page == $paginator->currentPage() ? 'page' : '' }}"
                              @if($page != $paginator->currentPage())
                                href="{{ $url }}"
                              @endif
                            >
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif
