@extends('layouts.app')

@section('content')
    <div class="mb-page-content-container">
        <div class="mb-content-offset-x-3">
            <h1 class="mb-page-title">zakaj postati boter?</h1>

            <ul class="list-disc mb-content-block ml-8 space-y-2">
                <li>
                    Ker s svojim prispevkom pomagate Mačji hiši <strong>omogočiti nekoč brezdomnim mucam varno
                        in zadovoljno življenje</strong>, četudi morda <strong>ne bodo nikoli posvojene</strong>.
                </li>
                <li>
                    Ker nam s svojo podporo <strong>omogočate rešiti še več brezdomnih muc</strong>.
                </li>
                <li>
                    Ker lahko že za 5 evrov mesečno pridobite <strong>zvestega mačjega prijatelja
                        za vse življenje</strong>.
                </li>
                <li>
                    Ker vas bo vaš novi prijatelj <strong>razveseljeval s pismi</strong> iz svojega navihanega
                    mačjega življenja.
                </li>
                <li>
                    Ker lahko vsi botri brezplačno postanete <strong>člani Kluba Mačja hiša</strong>.
                    Članstvo v klubu vam ne prinaša nobene obveznosti, imate pa kot član ugodne pogoje pri nakupih
                    v naši spletni trgovinici Super Čombe.
                </li>
                <li>
                    Ker občasno pripravimo svojim botrom <strong>majhna prijetna presenečenja</strong>.
                </li>
                <li>
                    Ker z botrstvom pokažete, da <strong>vam ni vseeno</strong> in da želite živeti v svetu,
                    prijaznem tako do ljudi, kot tudi do živali.
                </li>
                <li>
                    Ker <strong>vas muce potrebujejo</strong>.
                </li>
            </ul>

            <div class="mb-content-section">
                <h2 class="mb-content-section-title">kako postanem boter?</h2>

                <div class="mb-content-block">
                    Preprosto. Na spodnji povezavi si <strong>oglejte muce, ki iščejo botra</strong>. Izberite muco in
                    izpolnite <strong>Dogovor o posvojitvi na daljavo</strong>. Na svoj elektronski naslov boste prejeli
                    sporočilo o sklenjenem botrstvu. Potem pa vsak mesec sproti <strong>nakazujete izbrani znesek</strong>.
                </div>

                <a
                    class="mb-btn mb-btn-primary"
                    href="{{ route('cat_list') }}"
                    dusk="go-to-cats-list-link"
                >
                    <x-icon icon="arrow-right"></x-icon>
                    <span>muce, ki iščejo botra</span>
                </a>
            </div>
        </div>
    </div>
@endsection
