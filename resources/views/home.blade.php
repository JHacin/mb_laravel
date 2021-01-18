@extends('layouts.app')

@php
    use App\Models\Cat;

    $heroMenuItems = [
        [
            'icon' => 'far fa-question-circle',
            'text' => 'Zakaj postati mačji boter?',
            'link' => route('why_become_sponsor'),
        ],
        [
            'icon' => 'fas fa-cat',
            'text' => 'Muce, ki iščejo botra',
            'link' => route('cat_list'),
        ],
        [
            'icon' => 'fas fa-hands-helping',
            'text' => 'Postani boter meseca',
            'link' => '#',
        ],
        [
            'icon' => 'fas fa-gift',
            'text' => 'Podari botrstvo',
            'link' => '#',
        ],
    ];

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
    <div class="columns is-variable is-1">
        @foreach([$heroCats[0], $heroCats[1]] as $heroCat)
            <x-hero-cat :cat="$heroCat" />
        @endforeach
        <div class="column is-flex">
            <div class="hero-menu">
                @foreach($heroMenuItems as $item)
                    <a href="{{ $item['link'] }}" class="hero-menu-item">
                        <div class="icon is-large mr-5">
                            <i class="hero-menu-item__icon {{ $item['icon'] }}"></i>
                        </div>
                        <div class="hero-menu-item__text">
                            <span>{{ $item['text'] }}</span>
                            <i class="fas fa-arrow-circle-right"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <section class="section">
        <div class="container is-max-widescreen">
            <div class="columns">
                @foreach($stats as $stat)
                    <div class="stat-column column">
                        <div class="stat-column__value">
                            {{ $stat['value'] }}
                        </div>
                        <div class="stat-column__text">
                            {{ $stat['text'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="section mb-6">
        <div class="container is-max-widescreen">
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
                Postanete lahko <a href="#"><strong>redni boter</strong></a>, s čemer se zavežete k rednim
                mesečnim prispevkom do prekinitve.
                Lahko pa postanete <a href="#"><strong>Boter meseca</strong></a> in z nakazilom 10 €
                muckam pomagate samo izbrani mesec. Obe vrsti pomoči sta več kot dobrodošli in potrebni.
            </div>
            <div class="block">
                Botrstvo lahko tudi <a href="#"><strong>podarite</strong></a> in z njim razveselite obdarovanca
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
