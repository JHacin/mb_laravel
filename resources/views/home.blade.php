@extends('layouts.app')

@section('content')
    <div class="mb-page-content-container">
        <div class="grid grid-cols-1 auto-rows-fr md:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach ($heroCats as $heroCat)
                <x-hero-cat :cat="$heroCat"></x-hero-cat>
            @endforeach

            <a
                href="{{ route('cat_list') }}"
                class="rounded shadow hover:shadow-lg bg-[#e0d5d4] transition-all bg-no-repeat bg-cover bg-center"
                style="background-image: url('{{ mix('img/home_hero_vse_muce.svg') }}');"
            >
            </a>
        </div>

        <div class="py-section mb-content-offset-l-10">
            <x-home.intro-row>
                <x-slot name="title">
                    pomagamo mucam, ki
                    <span class="text-secondary">težje najdejo svoj dom.</span>
                </x-slot>
                <x-slot name="body">
                    <div>
                        Mačji boter je projekt <a
                            href="{{ config('links.macja_hisa') }}"
                            class="mb-link"
                        >Mačje hiše</a>, ki omogoča posvojitve muck na daljavo.
                        Namenjen je vsem tistim, ki nam želite pomagati pri oskrbi nekoč brezdomnih muck.
                        Gre za obliko donacije, ki donatorja poveže z določenim mucem ali skupino mucov in mu
                        hkrati omogoča boljši vpogled v to, za kaj je bil porabljen njegov prispevek.
                    </div>
                    <div>
                        V projekt Mačji boter so vključeni predvsem tisti mucki, ki iz različnih vzrokov
                        dalj časa iščejo svoj domali pa zaradi njihovih posebnosti
                        predvidevamo, da bodo pri nas dalj časa. S pomočjo mačjih botrov jim v skrbništvu
                        ves čas bivanja nudimo kvalitetno hrano, veterinarsko oskrbo in vse,
                        kar potrebujejo za srečno mačje življenje.
                        Tudi skrb, ljubezen, neprespane noči, solze, ko je hudo, in radost, ko gre na bolje.
                    </div>
                </x-slot>
            </x-home.intro-row>
        </div>

        <x-home.stats></x-home.stats>

        <div class="py-section mb-content-offset-l-10">
            <x-home.intro-row>
                <x-slot name="title">
                    botrujete lahko
                    <span class="text-secondary">na več načinov.</span>
                </x-slot>
                <x-slot name="body">
                    <div>
                        Mucam v oskrbi Mačje hiše lahko v okviru botrstva pomagate na več načinov.
                        Postanete lahko
                        <a
                            href="{{ route('why_become_sponsor') }}"
                            class="mb-link"
                            dusk="home-why-become-sponsor-link"
                        >redni boter</a>,
                        s čemer se zavežete k rednim
                        mesečnim prispevkom do prekinitve.
                        Lahko pa tudi izberete eno od
                        <a
                            href="{{ route('special_sponsorships') }}"
                            class="mb-link"
                            dusk="home-special-sponsorships-link"
                        >posebnih vrst botrstva</a>.
                        Vse vrste pomoči so več kot dobrodošle in potrebne.
                    </div>
                    <div>
                        Botrstvo lahko tudi
                        <a
                            href="{{ route('gift_sponsorship') }}"
                            class="mb-link"
                            dusk="home-gift-sponsorship-link"
                        >podarite</a>
                        in z njim razveselite obdarovanca
                        ter hkrati v njegovem imenu prispevate k boljšem življenju muc. Pri tem vam
                        ponujamo več različnih možnosti in upamo,
                        da boste med njimi našli tisto pravo ustrezno darilo, ki je eno, a osreči mnoge.
                    </div>
                </x-slot>
            </x-home.intro-row>
        </div>
    </div>
@endsection
