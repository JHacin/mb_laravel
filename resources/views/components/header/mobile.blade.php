@props(['pageLinks'])

<div
    class="hidden fixed top-0 left-0 w-full h-full bg-white z-50 flex overflow-hidden"
    data-mobile-nav
>
    <div class="grow flex flex-col">
        <div class="px-4 space-y-6">
            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('home') }}">
                    <img
                        src="{{ mix('img/logo.svg') }}"
                        alt="Mačji boter"
                        class="h-[60px] md:h-[90px] lg:h-[110px]"
                    >
                </a>

                <span
                    class="flex items-center cursor-pointer p-2 text-2xl md:text-4xl"
                    role="button"
                    data-mobile-nav-close-btn
                >
                    <x-icon icon="close"></x-icon>
                </span>
            </div>

            <div>
                @foreach ($pageLinks as $pageLink)
                    <a
                        class="block border-b border-gray-light py-3 font-semibold"
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
                    <span>Postani boter</span>
                </a>
            </div>

            <div>
                <h6 class="mb-2">Spremljajte nas</h6>
                <div class="flex gap-4 text-lg">
                    <a href="{{ config('links.facebook_page') }}">
                        <x-icon
                            class="hover:text-primary w-[12px]"
                            icon="facebook"
                        ></x-icon>
                    </a>
                    <a href="{{ config('links.instagram_page') }}">
                        <x-icon
                            class="hover:text-primary w-[12px]"
                            icon="instagram"
                        ></x-icon>
                    </a>
                </div>
            </div>
        </div>

        <div class="grow mt-6 bg-gray-extralight p-4">
            <x-footer.copy></x-footer.copy>
        </div>
    </div>
</div>
