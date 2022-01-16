@php
$filters = [
    [
        'query' => 'sponsorship_count',
        'label' => 'številu botrov',
    ],
    [
        'query' => 'age',
        'label' => 'starosti',
    ],
    [
        'query' => 'id',
        'label' => 'datumu objave',
    ],
];
@endphp

<div class="flex space-x-4">
    <h6 class="font-semibold">Razvrsti po:</h6>

    @foreach($filters as $filter)
        <div class="flex space-x-2">
            <x-cat-list.sort-link-toggle
                query="{{ $filter['query'] }}"
                label="{{ $filter['label'] }}"
            ></x-cat-list.sort-link-toggle>

            <x-cat-list.sort-link-arrow
                query="{{ $filter['query'] }}"
                direction="asc"
            ></x-cat-list.sort-link-arrow>

            <x-cat-list.sort-link-arrow
                query="{{ $filter['query'] }}"
                direction="desc"
            ></x-cat-list.sort-link-arrow>
        </div>
    @endforeach
</div>
