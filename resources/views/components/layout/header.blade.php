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
        [
            'label' => 'Pogosta vprašanja',
            'route_name' => 'faq',
            'dusk' => 'navbar-faq-link',
        ],
    ];
@endphp

{{-- Desktop nav --}}
<header
 class="flex items-center h-[64px] md:h-[95px] xl:h-[178px] 2xl:h-[206px]"
>
    <div class="mb-container flex-grow">
        <nav
            role="navigation"
            aria-label="glavni meni"
            class=" flex justify-between space-x-4"
        >
            <div class="flex items-center justify-between">
                <span
                  class="lg:hidden flex items-center cursor-pointer p-2 mr-4"
                  role="button"
                  data-mobile-nav-open-btn
                >
                    <x-icon icon="burger" class="text-2xl"></x-icon>
                </span>

                <a
                    href="{{ route('home') }}"
                    dusk="navbar-home-link"
                >
                    <img
                        src="{{ mix('img/logo.svg') }}"
                        alt="Mačji boter"
                        class="h-auto w-[70px] md:w-[80px] lg:w-[100px] xl:w-[135px] 2xl:w-[165px]"
                    >
                </a>
            </div>

            <div class="flex items-center">
                <div class="hidden lg:flex items-center space-x-4 mr-6 xl:space-x-6">
                    @foreach($pageLinks as $pageLink)
                        <a
                            class="
                            text-black
                            text-base
                            xl:text-lg
                            2xl:text-xl
                            transition-all
                            hover:text-gray-semi
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

{{-- Mobile nav --}}
<div
  class="hidden fixed top-0 left-0 w-full h-full bg-white z-50 flex overflow-hidden"
  data-mobile-nav
>
    <div class="grow flex flex-col">
        <div class="px-4 space-y-10">
            <div class="flex justify-between items-center mt-4">
                <a
                  href="{{ route('home') }}"
                >
                    <img
                      src="{{ mix('img/logo.svg') }}"
                      alt="Mačji boter"
                      class="h-auto w-[70px]"
                    >
                </a>

                <span
                  class="flex items-center cursor-pointer p-2"
                  role="button"
                  data-mobile-nav-close-btn
                >
              <x-icon icon="close" class="text-2xl"></x-icon>
            </span>
            </div>

            <div>
                @foreach($pageLinks as $pageLink)
                    <a
                      class="block border-b border-gray-light py-3 text-lg font-semibold"
                      href="{{ route($pageLink['route_name']) }}"
                    >
                        {{ $pageLink['label'] }}
                    </a>
                @endforeach
            </div>

            <div>
                <a
                    class="mb-btn mb-btn-primary block text-center"
                    href="{{ route('become_sponsor_overview') }}"
                >
                    <span>postani boter</span>
                </a>
            </div>

            <div>
                <h6 class="mb-2">Spremljajte nas</h6>
                <div class="flex gap-6 text-xl">
                    <a href="{{ config('links.facebook_page') }}">
                        <x-icon class="hover:text-primary w-[12px]" icon="facebook"></x-icon>
                    </a>
                    <a href="{{ config('links.instagram_page') }}">
                        <x-icon class="hover:text-primary w-[12px]" icon="instagram"></x-icon>
                    </a>
                </div>
            </div>
        </div>

        <div class="grow mt-10 bg-gray-extralight p-4">
            <x-footer.copy></x-footer.copy>
        </div>
    </div>
</div>
