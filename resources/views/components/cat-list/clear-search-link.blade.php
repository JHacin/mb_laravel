<a
    class="mb-link text-sm flex items-center space-x-2"
    href="{{ route('cat_list', array_merge($activeQueryParams, ['search' => null])) }}"
    dusk="clear-search-link"
>
    <x-icon icon="close"></x-icon>
    <span>Počisti iskanje</span>
</a>
