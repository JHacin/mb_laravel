@extends('layouts.app')

@php
    use App\Models\SpecialSponsorship;use JetBrains\PhpStorm\ArrayShape;

    $labels = SpecialSponsorship::TYPE_LABELS;
    $amounts = SpecialSponsorship::TYPE_AMOUNTS;

    function formLink(int $type): string {
        return route('special_sponsorships_form', ['tip' => $type]);
    }

    #[ArrayShape([
        'label' => "string",
        'amount' => "int",
        'formLink' => "string"
    ])]
    function makeTypeVars(int $type): array {
      return [
            'label' => SpecialSponsorship::TYPE_LABELS[$type],
            'amount' => SpecialSponsorship::TYPE_AMOUNTS[$type],
            'formLink' => formLink($type),
        ];
    }

    $type_boter_meseca = makeTypeVars(SpecialSponsorship::TYPE_BOTER_MESECA);
    $type_muc_gre_brez_skrbi_v_nove_dni = makeTypeVars(SpecialSponsorship::TYPE_MUC_GRE_BREZ_SKRBI_V_NOVE_DNI);
    $type_muca_gre_brez_skrbi_v_nove_dni = makeTypeVars(SpecialSponsorship::TYPE_MUCA_GRE_BREZ_SKRBI_V_NOVE_DNI);
    $type_nov_zacetek = makeTypeVars(SpecialSponsorship::TYPE_NOV_ZACETEK);
    $type_fip_bojevnik_za_1_dan = makeTypeVars(SpecialSponsorship::TYPE_FIP_BOJEVNIK_ZA_1_DAN);
    $type_fip_bojevnik_za_2_dni = makeTypeVars(SpecialSponsorship::TYPE_FIP_BOJEVNIK_ZA_2_DNI);
    $type_fip_bojevnik_za_1_teden = makeTypeVars(SpecialSponsorship::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN);
@endphp

@section('content')
    <div class="tw-section">
        <div class="tw-container tw-mx-auto">
            <h1 class="tw-title">Posebna botrstva</h1>

            <div class="tw-mb-6">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean hendrerit, ex eu sagittis rhoncus,
                enim risus facilisis neque, vitae lacinia diam eros at felis. Vivamus commodo rhoncus ipsum ut
                eleifend. Sed bibendum, nisl vel tristique varius, diam tortor maximus est, at finibus mi turpis ut
                libero. Duis erat diam, scelerisque id gravida eget, dignissim vitae elit. Praesent ac augue ut
                dolor congue finibus. Sed purus nibh, consectetur ac odio ac, feugiat vestibulum lacus. Donec id
                urna sed massa dignissim pellentesque. Sed at malesuada dolor. Aenean faucibus magna mauris, et
                iaculis erat consequat nec.
            </div>

            <div class="tw-mb-6">
                <strong>Pri tem vam ponujamo več možnosti:</strong>
            </div>

            <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-6">
                <div class="tw-col-span-1 lg:tw-col-span-3">
                    <div class="tw-special-sponsorship-type-card">
                        <h3 class="tw-special-sponsorship-type-card__title">
                            {{ $type_boter_meseca['label'] }}
                        </h3>
                        <div class="tw-special-sponsorship-type-card__content">
                            <div class="tw-mb-2">
                                Boter meseca je nastal v začetku leta 2013 in je namenjen vsem tistim, ki nam želite
                                pomagati pri oskrbi muc, ne da bi se pri tem zavezali k vsakomesečnim donacijam. Kot
                                Boter meseca nam pomagate takrat, ko to sami želite oz. zmorete.
                            </div>
                            <div>
                                Z donacijo <strong>{{ $type_boter_meseca['amount'] }} €</strong> postanete boter
                                tekočega meseca (Boter januar, Boter februar…) in tako
                                pomagate preživeti izbrani mesec vsem muckom, ki so takrat v oskrbi Mačje hiše. V zameno
                                za vašo donacijo boste prejeli
                                <strong>ozadje za namizje s koledarjem "vašega" meseca</strong>.
                                Verjamemo, da vam bo vsakodnevni pogled nanj pogosto izvabil nasmeh na obraz in tako
                                tudi vam polepšal izbrani mesec.
                            </div>
                        </div>
                        <div>
                            <a
                                class="tw-special-sponsorship-type-card__button"
                                href="{{ $type_boter_meseca['formLink'] }}"
                            >
                                <span class="tw-icon"><i class="fas fa-arrow-circle-right"></i></span>
                                <span>Izberi</span>
                            </a>
                        </div>
                    </div>

                    <div class="tw-special-sponsorship-type-card">
                        <h3 class="tw-special-sponsorship-type-card__title">
                            {{ $type_muc_gre_brez_skrbi_v_nove_dni['label'] }}
                        </h3>
                        <div class="tw-special-sponsorship-type-card__content">
                            <div class="tw-mb-2">
                                Z donacijo
                                <strong>{{ $type_muc_gre_brez_skrbi_v_nove_dni['amount'] }} €</strong>
                                pokrijete stroške kastracije enega mačka.
                            </div>
                            <div>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean hendrerit,
                                ex eu sagittis rhoncus, enim risus facilisis neque, vitae lacinia diam eros at felis.
                                Vivamus commodo rhoncus ipsum ut eleifend. Sed bibendum, nisl vel tristique varius,
                                diam tortor maximus est, at finibus mi turpis ut libero.
                            </div>
                        </div>
                        <div>
                            <a
                                class="tw-special-sponsorship-type-card__button"
                                href="{{ $type_muc_gre_brez_skrbi_v_nove_dni['formLink'] }}"
                            >
                                <span class="tw-icon"><i class="fas fa-arrow-circle-right"></i></span>
                                <span>Izberi</span>
                            </a>
                        </div>
                    </div>

                    <div class="tw-special-sponsorship-type-card">
                        <h3 class="tw-special-sponsorship-type-card__title">
                            {{ $type_muca_gre_brez_skrbi_v_nove_dni['label'] }}
                        </h3>
                        <div class="tw-special-sponsorship-type-card__content">
                            <div class="tw-mb-2">
                                Z donacijo
                                <strong>{{ $type_muca_gre_brez_skrbi_v_nove_dni['amount'] }} €</strong>
                                pokrijete stroške sterilizacije ene mačke.
                            </div>
                            <div>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean hendrerit,
                                ex eu sagittis rhoncus, enim risus facilisis neque, vitae lacinia diam eros at felis.
                                Vivamus commodo rhoncus ipsum ut eleifend. Sed bibendum, nisl vel tristique varius,
                                diam tortor maximus est, at finibus mi turpis ut libero.
                            </div>
                        </div>
                        <div>
                            <a
                                class="tw-special-sponsorship-type-card__button"
                                href="{{ $type_muca_gre_brez_skrbi_v_nove_dni['formLink'] }}"
                            >
                                <span class="tw-icon"><i class="fas fa-arrow-circle-right"></i></span>
                                <span>Izberi</span>
                            </a>
                        </div>
                    </div>

                    <div class="tw-special-sponsorship-type-card">
                        <h3 class="tw-special-sponsorship-type-card__title">
                            {{ $type_nov_zacetek['label'] }}
                        </h3>
                        <div class="tw-special-sponsorship-type-card__content">
                            <div class="tw-mb-2">
                                Z donacijo
                                <strong>{{ $type_nov_zacetek['amount'] }} €</strong>
                                enemu mucku zagotovite pregled, razparazitenje,
                                cepljenje proti kužnim boleznim, testiranje na FELV in FIV, čipiranje,
                                izdajo potnega lista in vnos v register
                            </div>
                            <div>
                                Z donacijo
                                <strong>{{ $type_nov_zacetek['amount'] }} €</strong>
                                postanete boter tekočega meseca (Boter januar,
                                Boter februar…) in tako
                                pomagate preživeti izbrani mesec vsem muckom, ki so takrat v oskrbi Mačje hiše. V
                                zameno
                                za vašo donacijo boste prejeli
                                <strong>ozadje za namizje s koledarjem "vašega" meseca</strong>.
                                Verjamemo, da vam bo vsakodnevni pogled nanj pogosto izvabil nasmeh na obraz in tako
                                tudi vam polepšal izbrani mesec.
                            </div>
                        </div>
                        <div>
                            <a
                                class="tw-special-sponsorship-type-card__button"
                                href="{{ $type_nov_zacetek['formLink'] }}"
                            >
                                <span class="tw-icon"><i class="fas fa-arrow-circle-right"></i></span>
                                <span>Izberi</span>
                            </a>
                        </div>
                    </div>

                    <hr class="mb-6">

                    <h2 class="title is-3">FIP bojevniki</h2>
                    <div class="mb-6">
                        FIP bojevniki so mucki, oboleli za do pred kratkim smrtnonosno boleznijo mačjega infekcioznega
                        peritonitisa (Feline Infectious Peritonitis ali FIP). Ob postavljeni diagnozi smo še nedavno
                        vedeli, da je mucek obsojen na smrt. Sedaj je FIP postal ozdravljiv, zdravilo zanj dostopno, je
                        pa zdravljenje dolgotrajno in zaenkrat še zelo drago. Mačji FIP bojevnik prejema zdravila vsaj
                        12 tednov (84 dni), ob tem potrebuje redne kontrole in vitaminsko podporo. Odmerek zdravila se
                        prilagaja glede na težo mucka in obliko bolezni, v povprečju pa znaša strošek zdravljenja 25
                        evrov na dan. Zaradi visokih stroškov je botrstvo FIP bojevnik vseskozi aktivno, tudi takrat, ko
                        noben muc ni bolan, saj želimo vsem našim muckom v prihodnje omogočiti zdravljenje. Zato zanje
                        ustanavljamo poseben FIP sklad. Z botrstvom tako pomagate enemu trenutnemu ali bodočemu FIP
                        bojevniku na njegovi poti do FIP zmagovalca.
                    </div>
                    <div class="tw-mb-6">
                        <strong>Pomagate lahko kot:</strong>
                    </div>

                    <div class="tw-special-sponsorship-type-card">
                        <h3 class="tw-special-sponsorship-type-card__title">
                            {{ $type_fip_bojevnik_za_1_dan['label'] }}
                        </h3>
                        <div class="tw-special-sponsorship-type-card__content">
                            <div>
                                Z donacijo
                                <strong>{{ $type_fip_bojevnik_za_1_dan['amount'] }} €</strong>
                                enemu FIP bojevniku omogočite zdravilo za en dan. V zahvalo vi ali
                                vaš obdarovanec prejmete elektronsko potrdilo/diplomo FIP bojevnik. V primeru, da v času
                                vašega botrstva zdravimo katerega od muckov, vas obvestimo o tem, komu smo namenili
                                botrstvo in kako poteka zdravljenje.
                            </div>
                        </div>
                        <div>
                            <a
                                class="tw-special-sponsorship-type-card__button"
                                href="{{ $type_fip_bojevnik_za_1_dan['formLink'] }}"
                            >
                                <span class="tw-icon"><i class="fas fa-arrow-circle-right"></i></span>
                                <span>Izberi</span>
                            </a>
                        </div>
                    </div>

                    <div class="tw-special-sponsorship-type-card">
                        <h3 class="tw-special-sponsorship-type-card__title">
                            {{ $type_fip_bojevnik_za_2_dni['label'] }}
                        </h3>
                        <div class="tw-special-sponsorship-type-card__content">
                            <div>
                                Z donacijo
                                <strong>{{ $type_fip_bojevnik_za_2_dni['amount'] }} €</strong>
                                enemu FIP bojevniku omogočite zdravilo za dva dni. V zahvalo vi ali
                                vaš obdarovanec prejmete elektronsko potrdilo/diplomo FIP bojevnik. V primeru, da v času
                                vašega botrstva zdravimo katerega od muckov, vas obvestimo o tem, komu smo namenili
                                botrstvo in kako poteka zdravljenje.
                            </div>
                        </div>
                        <div>
                            <a
                                class="tw-special-sponsorship-type-card__button"
                                href="{{ $type_fip_bojevnik_za_2_dni['formLink'] }}"
                            >
                                <span class="tw-icon"><i class="fas fa-arrow-circle-right"></i></span>
                                <span>Izberi</span>
                            </a>
                        </div>
                    </div>

                    <div class="tw-special-sponsorship-type-card">
                        <h3 class="tw-special-sponsorship-type-card__title">
                            {{ $type_fip_bojevnik_za_1_teden['label'] }}
                        </h3>
                        <div class="tw-special-sponsorship-type-card__content">
                            <div>
                                Z donacijo
                                <strong>{{ $type_fip_bojevnik_za_1_teden['amount'] }} €</strong>
                                enemu FIP bojevniku omogočite en teden zdravljenja, kar pomeni 1/12
                                vseh stroškov zdravljenja za enega muca. V zahvalo vi ali vaš obdarovanec prejmete
                                elektronsko potrdilo/diplomo FIP bojevnik, za dve leti vas (ga) uvrstimo med redne botre
                                mucka Čombeta in prejemate vse, kar prejemajo mačji botri (pisma muckov, voščilo dostop
                                do mesečnih namizij ...). V primeru, da v času vašega botrstva zdravimo katerega od
                                muckov, vas obvestimo o tem, komu smo namenili botrstvo in kako poteka zdravljenje.
                            </div>
                        </div>
                        <div>
                            <a
                                class="tw-special-sponsorship-type-card__button"
                                href="{{ $type_fip_bojevnik_za_1_teden['formLink'] }}"
                            >
                                <span class="tw-icon"><i class="fas fa-arrow-circle-right"></i></span>
                                <span>Izberi</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tw-col-span-1 lg:tw-col-span-2 lg:tw-col-start-5">
                    <x-special-sponsorships.sponsors-of-this-month />
                </div>
            </div>
        </div>
    </div>
@endsection
