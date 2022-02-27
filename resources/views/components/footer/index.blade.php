<footer class="bg-gray-extralight shadow-lg">
    <div class="mb-page-content-container">
        <div class="mb-12 lg:mb-14 lg:flex lg:justify-between lg:items-center xl:mb-16 2xl:mb-18">
            <div class="mb-6">
                <img
                    src="{{ mix('img/logo.svg') }}"
                    alt="Mačji boter"
                    class="h-[60px] md:h-[75px] lg:h-[90px]"
                >
            </div>

            <div class="mb-typography-content-base mb-font-primary-bold">
                <span class="text-primary">Hvala</span>
                za vso pomoč, muce jo resnično potrebujejo.
            </div>
        </div>

        <div class="text-gray-dark grid pb-2 lg:grid-cols-3 lg:pb-6 2xl:grid-cols-4 2xl:pb-8 xl:gap-36 2xl:gap-48">
            <div
                class="mb-8 space-y-8 lg:space-y-0 lg:col-span-2 lg:col-start-2 lg:gap-12 lg:flex 2xl:col-span-3 xl:gap-24 2xl:gap-36">
                <div>
                    <h6 class="mb-typography-content-base mb-3 lg:mb-4 xl:mb-5 2xl:mb-6">Obiščite tudi</h6>
                    <div class="text-gray-dark text-sm font-light space-y-2">
                        <a
                            class="block hover:underline"
                            href="{{ config('links.macja_hisa') }}"
                            dusk="footer-mh-link"
                        >
                            Mačja hiša
                        </a>
                        <a
                            class="block hover:underline"
                            href="{{ config('links.veterina_mh') }}"
                            dusk="footer-vet-link"
                        >
                            Veterina MH
                        </a>
                        <a
                            class="block hover:underline"
                            href="{{ config('links.super_combe') }}"
                            dusk="footer-combe-link"
                        >
                            Spletna trgovina Super Čombe
                        </a>
                        <a
                            class="block hover:underline"
                            href="{{ config('links.pomagamo_zivalim') }}"
                            dusk="footer-pomagamo-zivalim-link"
                        >
                            Forumi Pomagamo živalim
                        </a>
                    </div>
                </div>

                <div>
                    <h6 class="mb-typography-content-base mb-3 lg:mb-4 xl:mb-5 2xl:mb-6">Botrstvo</h6>
                    <div class="text-sm font-light space-y-2">
                        <a
                            class="block hover:underline"
                            href="{{ route('cat_list') }}"
                        >Muce, ki iščejo dom</a>
                        <a
                            class="block hover:underline"
                            href="{{ route('why_become_sponsor') }}"
                        >Zakaj postati mačji boter</a>
                        <a
                            class="block hover:underline"
                            href="{{ route('special_sponsorships') }}"
                        >Posebna botrstva</a>
                        <a
                            class="block hover:underline"
                            href="{{ route('gift_sponsorship') }}"
                        >Podari botrstvo</a>
                        <a
                            class="block hover:underline"
                            href="{{ route('special_sponsorships_archive') }}"
                        >Arhiv botrov</a>
                    </div>
                </div>

                <div>
                    <h6 class="mb-typography-content-base mb-3 lg:mb-4 xl:mb-5 2xl:mb-6">O projektu</h6>
                    <div class="text-sm font-light space-y-2">
                        <a
                            class="block hover:underline"
                            href="{{ route('news') }}"
                        >Novice</a>
                        <a
                            class="block hover:underline"
                            href="{{ route('faq') }}"
                        >Pogosta vprašanja</a>
                    </div>
                </div>

            </div>

            <div class="lg:col-start-1 lg:row-start-1 space-y-8 mb-8">
                <div>
                    <h6 class="mb-typography-content-base mb-3 lg:mb-4 xl:mb-5 2xl:mb-6">Spremljajte nas</h6>
                    <div class="space-y-2">
                        <a
                            class="text-sm font-light flex items-center space-x-2"
                            href="{{ config('links.facebook_page') }}"
                        >
                            <x-icon
                                class="hover:text-primary w-[12px]"
                                icon="facebook"
                            ></x-icon>
                            <span class="hover:underline">Facebook</span>
                        </a>
                        <a
                            class="text-sm font-light flex items-center space-x-2"
                            href="{{ config('links.instagram_page') }}"
                        >
                            <x-icon
                                class="hover:text-primary w-[12px]"
                                icon="instagram"
                            ></x-icon>
                            <span class="hover:underline">Instagram</span>
                        </a>
                    </div>
                </div>

                <div>
                    <h6 class="mb-typography-content-base mb-1 xl:mb-2">Kontakt</h6>
                    <div class="text-sm font-light flex items-center space-x-2">
                        <x-icon icon="email"></x-icon>
                        <a
                            class="hover:underline"
                            href="mailto:{{ config('links.contact_email') }}"
                        >{{ config('links.contact_email') }}</a>
                    </div>
                </div>

                <div>
                    <div class="text-base mb-1 xl:mb-2">Želite sponzorirati projekt?</div>
                    <div class="text-sm font-light">
                        Pišite nam na <a
                            class="hover:underline"
                            href="mailto:{{ config('links.mh_email') }}"
                        >info@macjahisa.si</a>.
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-gray-light">

        <div class="pt-4 lg:pt-6 xl:pt-8 2xl:pt-10">
            <x-footer.copy></x-footer.copy>
        </div>
    </div>
</footer>
