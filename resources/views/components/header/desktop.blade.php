@props(['pageLinks'])

@php
$currentRouteName = Route::currentRouteName();
$isHomepage = $currentRouteName === 'home';
@endphp

<header class="flex items-center py-2 md:py-4 lg:py-6 xl:py-8 2xl:py-10">
    <div class="mb-container flex-grow">
        <nav
            role="navigation"
            aria-label="glavni meni"
            class="flex justify-between space-x-4"
        >
            <div class="flex items-center justify-between">
                <span
                    class="xl:hidden flex items-center cursor-pointer p-2 mr-4"
                    role="button"
                    data-mobile-nav-open-btn
                >
                    <x-icon
                        icon="burger"
                        class="text-2xl"
                    ></x-icon>
                </span>

                <a
                    href="{{ route('home') }}"
                    dusk="navbar-home-link"
                >
                    <img
                        src="{{ mix($isHomepage ? 'img/logo.svg' : 'img/logo_without_text.svg') }}"
                        alt="Mačji boter"
                        @class([
                            'h-[45px] md:h-[60px] lg:h-[75px] xl:h-[90px] 2xl:h-[110px]' => !$isHomepage,
                            'h-[75px] md:h-[90px] lg:h-[105px] xl:h-[130px] 2xl:h-[160px]' => $isHomepage,
                        ])
                    >
                </a>
            </div>

            <div class="flex items-center">
                <div class="hidden xl:flex items-center space-x-4 mr-6 xl:space-x-6">
                    @foreach ($pageLinks as $pageLink)
                        <a
                            @class([
                                'text-base transition-all hover:text-gray-semi',
                                'underline underline-offset-4 decoration-dashed decoration-2 decoration-primary hover:decoration-primary hover:text-black' =>
                                    $currentRouteName === $pageLink['route_name'],
                            ])
                            href="{{ route($pageLink['route_name']) }}"
                            dusk="{{ $pageLink['dusk'] }}"
                        >
                            {{ $pageLink['label'] }}
                        </a>
                    @endforeach
                </div>

                <a
                    class="mb-btn mb-btn-primary justify-self-end"
                    href="{{ route('become_sponsor_overview') }}"
                >
                    <span>postani boter</span>
                </a>
            </div>
        </nav>
    </div>
</header>
