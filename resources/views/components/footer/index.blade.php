<footer class="mb-section-masked shadow-lg">
    <div class="border-b border-dashed border-gray-light">
        <div class="mb-container">
            <div class="grid lg:grid-cols-4">
                <div class="mb-footer-column">
                    <h6 class="mb-footer-heading">Obiščite tudi</h6>
                    <div class="mb-footer-list">
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

                <div class="mb-footer-column">
                    <h6 class="mb-footer-heading">Botrstvo</h6>
                    <div class="mb-footer-list">
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

                <div class="mb-footer-column">
                    <h6 class="mb-footer-heading">O projektu</h6>
                    <div class="mb-footer-list">
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

                <div class="mb-footer-column space-y-6">
                    <div>
                        <h6 class="mb-footer-heading">Spremljajte nas</h6>
                        <div class="mb-footer-list">
                            <a
                                class="flex items-center space-x-2"
                                href="{{ config('links.facebook_page') }}"
                            >
                                <x-icon
                                    class="hover:text-primary w-[12px]"
                                    icon="facebook"
                                ></x-icon>
                                <span class="hover:underline">Facebook</span>
                            </a>
                            <a
                                class="flex items-center space-x-2"
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
                        <h6 class="mb-footer-heading">Kontakt</h6>
                        <div class="mb-footer-list">
                            <div class="flex items-center space-x-2">
                                <x-icon icon="email"></x-icon>
                                <a
                                    class="hover:underline"
                                    href="mailto:{{ config('links.contact_email') }}"
                                >{{ config('links.contact_email') }}</a>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-footer-heading">Želite sponzorirati projekt?</div>
                        <div class="mb-footer-list">
                            Pišite nam na
                            <a
                                class="hover:underline"
                                href="mailto:{{ config('links.mh_email') }}"
                            >info@macjahisa.si</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-container py-7">
        <x-footer.copy></x-footer.copy>
    </div>
</footer>
