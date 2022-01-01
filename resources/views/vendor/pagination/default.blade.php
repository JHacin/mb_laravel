{{--Todo: disable link functionality if href equals empty string--}}

@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="premikanje po straneh">
        {{-- Previous Page Link --}}
        <x-button
            as="link"
            variant="base"
            is-disabled="{{ $paginator->onFirstPage() }}"
            class="pagination-previous"
            href="{{ $paginator->onFirstPage() ? '' : $paginator->previousPageUrl() }}"
            rel="{{ $paginator->onFirstPage() ? '' : 'prev' }}"
            aria-label="@lang('pagination.previous')"
            dusk="pagination-previous"
        >
            @lang('pagination.previous')
        </x-button>

        {{-- Next Page Link --}}
        <x-button
            as="link"
            variant="base"
            is-disabled="{{ !$paginator->hasMorePages() }}"
            class="pagination-next"
            href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '' }}"
            rel="{{ $paginator->hasMorePages() ? 'next' : '' }}"
            aria-label="@lang('pagination.next')"
            dusk="pagination-next"
        >
            @lang('pagination.next')
        </x-button>

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
                            <x-button
                                as="link"
                                class="pagination-link {{ $page == $paginator->currentPage() ? 'pagination-link--is-current' : '' }}"
                                aria-label="{{ $page == $paginator->currentPage() ? 'Stran '.$page : 'Pojdi na stran'.$page }}"
                                aria-current="{{ $page == $paginator->currentPage() ? 'page' : '' }}"
                                href="{{ $page != $paginator->currentPage() ? $url : '' }}"
                            >
                                {{ $page }}
                            </x-button>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif
