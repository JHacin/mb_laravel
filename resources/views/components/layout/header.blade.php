@php
    $currentRouteName = Route::currentRouteName();

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
    ];
@endphp

<header
 class="flex items-center h-[64px] md:h-[95px] xl:h-[178px] 2xl:h-[206px]"
>
    <div class="mb-container flex-grow">
        <nav
            role="navigation"
            aria-label="glavni meni"
            class=" flex justify-between space-x-4"
        >
            <div class="flex items-center">
                <x-icon icon="burger" class="lg:hidden text-2xl mr-4"></x-icon>

                <a
                    href="{{ route('home') }}"
                    dusk="navbar-home-link"
                >
                    <img
                        src="{{ mix('img/logo.png') }}"
                        alt="Mačji boter"
                        class="h-auto w-[70px] md:w-[80px] lg:w-[100px] xl:w-[135px] 2xl:w-[165px]"
                    >
                </a>
            </div>

            <div class="flex items-center">
                <div class="hidden lg:flex items-center space-x-4 mr-6">
                    @foreach($pageLinks as $pageLink)
                        <a
                            class="
                            text-black
                            text-base
                            xl:text-lg
                            2xl:text-xl
                            transition-all
                            hover:text-gray-500
                            @if($currentRouteName === $pageLink['route_name'])
                                underline
                                underline-offset-4
                                decoration-dashed
                                decoration-2
                                decoration-primary
                                hover:decoration-primary
                                hover:text-black
                            @endif
                                "
                            href="{{ route($pageLink['route_name']) }}"
                            dusk="{{ $pageLink['dusk'] }}"
                        >
                            {{ $pageLink['label'] }}
                        </a>
                    @endforeach
                </div>

                <a class="mb-btn mb-btn-primary justify-self-end">
                    <span>postani boter</span>
                </a>
            </div>
        </nav>
    </div>
</header>
