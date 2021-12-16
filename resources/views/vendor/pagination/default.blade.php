@if ($paginator->hasPages())
    <nav class="tw-pagination" role="navigation" aria-label="premikanje po straneh">
        {{-- Previous Page Link --}}
        <a
            class="tw-pagination-previous"
            aria-label="@lang('pagination.previous')"
            dusk="pagination-previous"
            @if ($paginator->onFirstPage())
                aria-disabled="true"
                disabled
            @else
                href="{{ $paginator->previousPageUrl() }}"
                rel="prev"
            @endif
        >
            @lang('pagination.previous')
        </a>

        {{-- Next Page Link --}}
        <a
            class="tw-pagination-next"
            aria-label="@lang('pagination.next')"
            dusk="pagination-next"
            @if ($paginator->hasMorePages())
                href="{{ $paginator->nextPageUrl() }}"
                rel="next"
            @else
                aria-disabled="true"
                disabled
            @endif
        >
            @lang('pagination.next')
        </a>

        <ul class="tw-pagination-list">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="tw-pagination-ellipsis" aria-disabled="true">&hellip;</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            <a
                                class="tw-pagination-link {{ $page == $paginator->currentPage() ? 'tw-pagination-link--is-current' : '' }}"
                                dusk="pagination-link-page-{{ $page }}"
                                @if ($page == $paginator->currentPage())
                                    aria-label="Stran {{ $page }}"
                                    aria-current="page"
                                @else
                                    href="{{ $url }}"
                                    aria-label="Pojdi na stran {{ $page }}"
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
