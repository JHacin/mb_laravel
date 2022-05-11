@php
$pageLinks = [
    [
        'label' => 'Redno botrstvo',
        'route_name' => 'cat_list',
        'dusk' => 'navbar-cat-list-link',
    ],
    [
        'label' => 'Posebna botrstva',
        'route_name' => 'special_sponsorships',
        'dusk' => 'navbar-special-sponsorships-link',
    ],
    [
        'label' => 'Podari botrstvo',
        'route_name' => 'gift_sponsorship',
        'dusk' => 'navbar-gift-sponsorship-link',
    ],
    [
        'label' => 'Novice',
        'route_name' => 'news',
        'dusk' => 'navbar-news-link',
    ],
    [
        'label' => 'Pogosta vprašanja',
        'route_name' => 'faq',
        'dusk' => 'navbar-faq-link',
    ],
];
@endphp

{{-- Desktop nav --}}
<x-header.desktop :pageLinks="$pageLinks"></x-header.desktop>

{{-- Mobile nav --}}
<x-header.mobile :pageLinks="$pageLinks"></x-header.mobile>
