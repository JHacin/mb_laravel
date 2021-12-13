@extends('layouts.app')

@php
    use App\Models\Cat;

    $stats = [
        [
            'value' => '3800+',
            'text' => 'muc je našlo dom s pomočjo Mačje hiše od nastanka leta 2009',
        ],
        [
            'value' => Cat::count(),
            'text' => 'muc se je vključilo v botrstvo od začetka projekta marca 2013',
        ],
        [
            'value' => 8,
            'text' => 'mesecev je povprečna doba vključenosti muce v botrstvo',
        ],
        [
            'value' => '300+',
            'text' => 'različnih botrov nam je od začetka projekta pomagalo skrbeti za muce',
        ],
    ]
@endphp

@section('content')
    <div class="columns is-variable is-1 mb-0">
        @foreach($heroCats as $heroCat)
            <x-hero-cat :cat="$heroCat" />
        @endforeach
    </div>

    <section class="section">
        <div class="container is-max-widescreen">
            <div class="columns is-multiline mb-6">
                @foreach($stats as $stat)
                    <div class="stat-column column is-6-tablet is-3-widescreen">
                        <div class="stat-column__value">
                            {{ $stat['value'] }}
                        </div>
                        <div class="stat-column__text">
                            {{ $stat['text'] }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="block">
                Mačji boter je projekt <strong>Mačje hiše</strong>, ki omogoča posvojitve muck na daljavo.
                Namenjen je vsem tistim, ki nam želite <strong>pomagati pri oskrbi nekoč brezdomnih muck</strong>.
                Gre za obliko donacije, ki donatorja poveže z določenim mucem ali skupino mucov in mu
                hkrati <strong>omogoča boljši vpogled v to, za kaj je bil porabljen njegov prispevek</strong>.
            </div>
            <div class="block">
                V projekt Mačji boter so vključeni predvsem tisti mucki, ki iz različnih vzrokov
                <strong>dalj časa iščejo svoj dom</strong> ali pa zaradi njihovih posebnosti
                predvidevamo, da bodo pri nas dalj časa. S pomočjo mačjih botrov jim v skrbništvu
                ves čas bivanja nudimo kvalitetno hrano, veterinarsko oskrbo in vse,
                kar potrebujejo za srečno mačje življenje.
                Tudi skrb, ljubezen, neprespane noči, solze, ko je hudo, in radost, ko gre na bolje.
            </div>
            <div class="block">
                Mucam v oskrbi Mačje hiše lahko v okviru botrstva pomagate na več načinov.
                Postanete lahko
                <a href="{{ route('why_become_sponsor') }}" dusk="home-why-become-sponsor-link"><strong>redni boter</strong></a>,
                s čemer se zavežete k rednim
                mesečnim prispevkom do prekinitve.
                Lahko pa tudi izberete eno od
                <a href="{{ route('special_sponsorships') }}" dusk="home-special-sponsorships-link"><strong>posebnih vrst botrstva</strong></a>.
                Vse vrste pomoči so več kot dobrodošle in potrebne.
            </div>
            <div class="block">
                Botrstvo lahko tudi
                <a href="{{ route('gift_sponsorship') }}" dusk="home-gift-sponsorship-link"><strong>podarite</strong></a>
                in z njim razveselite obdarovanca
                ter hkrati v njegovem imenu prispevate k boljšem življenju muc. Pri tem vam
                ponujamo več različnih možnosti in upamo,
                da boste med njimi našli tisto pravo ustrezno darilo, ki je eno, a osreči mnoge.
            </div>
            <div class="block">
                <strong>Hvala za vso pomoč, muce jo resnično potrebujejo!</strong>
            </div>
        </div>
    </section>
@endsection
