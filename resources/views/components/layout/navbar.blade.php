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

<header class="tw-bg-primary">
    <nav
        role="navigation"
        aria-label="glavni meni"
        class="
        tw-px-4 tw-py-3 tw-grid tw-grid-cols-[60px_1fr_auto] tw-items-center
        xl:tw-grid-cols-[132px_1fr] xl:tw-grid-rows-[1fr_1fr] tw-max-w-screen-xl tw-mx-auto
    "
    >
        <a
            href="{{ route('home') }}"
            dusk="navbar-home-link"
            class="xl:tw-row-span-2"
        >
            <img src="{{ mix('img/logo.png') }}" alt="Mačji boter">
        </a>

        <div class="tw-flex tw-justify-self-end tw-mr-4 xl:tw-mr-0">
            @foreach($socialLinks as $socialLink)
                <a
                    href="{{ $socialLink['href'] }}"
                    class="tw-text-white hover:tw-text-gray-200 tw-mx-1 tw-text-xl"
                    dusk="{{ $socialLink['dusk'] }}"
                    target="_blank"
                >
                    <i class="{{ $socialLink['icon'] }}"></i>
                </a>
            @endforeach
        </div>

        <div class="tw-hidden xl:tw-flex tw-justify-end">
            @foreach($pageLinks as $pageLink)
                <a
                    class="
                        tw-text-white tw-font-semibold tw-p-3 hover:tw-bg-white
                        {{ $currentRouteName === $pageLink['route_name'] ? ' tw-bg-white tw-text-black' : '' }}
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
            xl:tw-hidden
            tw-flex tw-items-center tw-w-[40px] tw-h-[26px] tw-cursor-pointer
            tw-border-y-2 tw-border-white hover:tw-border-gray-200 hover:before:tw-border-gray-200
            before:tw-block before:tw-w-full before:tw-h-0 before:tw-border-white before:tw-border-b-2
        "
            aria-label="meni"
            aria-expanded="false"
        >
        </a>
    </nav>
</header>
