@extends('layouts.app')

@section('content')
    <div class="mb-container">
        <div class="mb-content-offset-l-10">
            <h1 class="mb-page-title">pogosta vprašanja</h1>
        </div>

        <div class="mb-content-offset-l-11 mb-content-offset-r-8 mt-section">
            <x-faq-item title="Kako postanem mačji boter?">
                <p>
                    Preprosto. Oglejte si <a
                        class="mb-link"
                        href="{{ route('cat_list') }}"
                    >muce, ki iščejo botra</a>. Izberite muco in ob njenem imenu kliknite
                    <em>Želiš postati moj boter</em>? Izpolnite in pošljite <strong>Dogovor o posvojitvi na
                        daljavo</strong>.
                    Na svoj elektronski naslov boste prejeli sporočilo o sklenjenem botrstvu.
                    Potem pa vsak mesec sproti nakazujete izbrani znesek.
                </p>
                <p>
                    Po prejemu vaših podatkov bomo smatrali, da se vaših nakazil lahko nadejamo do
                    prekinitve dogovora z vaše strani.
                </p>
            </x-faq-item>

            <x-faq-item title="Ne morem se odločiti za eno muco. Kaj storiti?">
                <p>
                    Med mucami, ki iščejo botra je tudi naš <strong>Čombe</strong>, ki je pokrovitelj vseh naših muckov.
                    Če se ne morete odločiti za enega muca, postanite njegov boter. Čombe vam obljublja,
                    da bo vaš denar pošteno razdelil tistim, ki ga v danem trenutku najbolj potrebujejo.
                </p>
                <p>
                    Posvojite pa lahko tudi <strong>Bubije</strong>, s čemer nam pomagate pri oskrbi mačjih dudarjev in
                    mladičev
                    ali pa <strong>Pozitivčke</strong>, FeLV (mačja levkoza) in/ali FIV (mačji aids) pozitivne muce brez
                    kliničnih
                    znakov bolezni.
                </p>
            </x-faq-item>

            <x-faq-item title="Kako prekiniti dogovor o posvojitvi na daljavo?">
                <p>
                    Če boste želeli prekiniti dogovor, nam z elektronskega naslova, ki ste ga navedli ob izpolnitvi
                    Dogovora o posvojitvi na daljavo, pošljite elektronsko sporočilo, v katerem navedite,
                    da odstopate od dogovora.
                </p>
                <p>
                    V primeru, da vaših prispevkov za botrstvo ne bomo prejemali, si pridržujemo pravico,
                    da vaše botrstvo prekinemo brez opozorila.
                </p>
            </x-faq-item>

            <x-faq-item title="Kaj dobi boter v zameno za svojo donacijo?">
                <p>Botrom se bodo njihovi mucki ob različnih priložnostih oglasili z novicami.</p>
                <p>
                    Ime in kraj bivanja botra bo naveden ob imenu muca na spletni strani
                    (razen v primeru, ko želi boter ostati anonimen).
                </p>
                <p>
                    V primeru, da se bo za posvojitev na daljavo odločilo podjetje,
                    lahko objavimo tudi povezavo na vašo spletno stran.
                </p>
                <p>
                    Botri lahko postanete tudi član <strong>kluba Super Čombe</strong>. Članstvo v klubu vam ne prinaša
                    nobene
                    obveznosti,
                    imate pa kot član ugodne pogoje pri nakupih v naši spletni trgovini Super Čombe.
                    Za ureditev članstva nam po registraciji v spletni trgovini pišite na
                    <a href="mailto:trgovina@supercombe.si">trgovina@supercombe.si</a>.
                </p>
            </x-faq-item>

            <x-faq-item title="Za kaj bo porabljen moj denar?">
                <p>
                    Denar bo porabljen za oskrbo (kvalitetna hrana, pesek, sredstva proti zajedalcem,
                    veterinarski stroški...) vaše in drugih muc pod okriljem Mačje hiše.
                </p>
            </x-faq-item>
        </div>
    </div>
@endsection
