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

<div>
    <div class="mb-input-label">Razvrsti po:</div>

    <div class="flex flex-col space-y-2 lg:flex-row lg:items-center lg:space-x-2 lg:space-y-0">
        @foreach ($filters as $filter)
            <div class="flex space-x-2 h-[42px] px-3 py-2 border border-gray-light rounded">
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
</div>
