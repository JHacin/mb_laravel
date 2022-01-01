@php
    $currentRouteName = Route::currentRouteName();

    $pageLinks = [
        [
            'label' => 'Postani redni boter',
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
    ];

    $socialLinks = [
        [
            'href' => 'mailto:' . config('links.contact_email'),
            'icon' => 'fas fa-envelope',
            'dusk' => 'navbar-contact-email-link',
        ],
        [
            'href' => config('links.instagram_page'),
            'icon' => 'fab fa-instagram-square',
            'dusk' => 'navbar-instagram-link',
        ],
        [
            'href' => config('links.facebook_page'),
            'icon' => 'fab fa-facebook',
            'dusk' => 'navbar-facebook-link',
        ],
    ];
@endphp

<header class="bg-primary">
    <nav
        role="navigation"
        aria-label="glavni meni"
        class="
        px-4 py-3 grid grid-cols-[60px_1fr_auto] items-center
        xl:grid-cols-[132px_1fr] xl:grid-rows-[1fr_1fr] max-w-screen-xl mx-auto
    "
    >
        <a
            href="{{ route('home') }}"
            dusk="navbar-home-link"
            class="xl:row-span-2"
        >
            <img src="{{ mix('img/logo.png') }}" alt="Mačji boter">
        </a>

        <div class="flex justify-self-end mr-4 xl:mr-0">
            @foreach($socialLinks as $socialLink)
                <a
                    href="{{ $socialLink['href'] }}"
                    class="text-white hover:text-gray-200 mx-1 text-xl flex items-center"
                    dusk="{{ $socialLink['dusk'] }}"
                    target="_blank"
                >
                    <x-icon icon-class="{{ $socialLink['icon'] }}"></x-icon>
                </a>
            @endforeach
        </div>

        <div class="hidden xl:flex justify-end">
            @foreach($pageLinks as $pageLink)
                <a
                    class="
                        text-white font-semibold p-3 hover:bg-white
                        {{ $currentRouteName === $pageLink['route_name'] ? ' bg-white text-black' : '' }}
                    "
                    href="{{ route($pageLink['route_name']) }}"
                    dusk="{{ $pageLink['dusk'] }}"
                >
                    {{ $pageLink['label'] }}
                </a>
            @endforeach
        </div>

        <a
            role="button"
            class="
            xl:hidden
            flex items-center w-[40px] h-[26px] cursor-pointer
            border-y-2 border-white hover:border-gray-200 hover:before:border-gray-200
            before:block before:w-full before:h-0 before:border-white before:border-b-2
        "
            aria-label="meni"
            aria-expanded="false"
        >
        </a>
    </nav>
</header>
