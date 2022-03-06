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

<div class="flex flex-col lg:flex-row lg:items-center lg:space-x-3">
    <div class="font-extrabold">Razvrsti po:</div>

    @foreach ($filters as $filter)
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
