@extends('layouts.app')

@php
    use App\Models\SpecialSponsorship;
    use JetBrains\PhpStorm\ArrayShape;

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
    <div class="mb-page-content-container">
        <div class="mb-page-header-container">
            <h1 class="mb-page-title">posebna botrstva</h1>
            <h2 class="mb-page-subtitle">
                Pri oskrbi muc nam lahko pomagate tudi brez, da bi se pri tem zavezali k vsakomesečnim donacijam za
                določeno muco ali skupino muc. Posebna botrstva so enkratne donacije, ki nam jih lahko namenite
                takrat, ko to želite oz. zmorete. Pri tem vam ponujamo več možnosti, od splošne donacije do bolj
                usmerjenih, s katerimi pomagate pri oskrbi muc, ki to najbolj potrebujejo.
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-6">
            <div class="col-span-1 lg:col-span-3 space-y-8 lg:space-y-10 xl:space-y-12">
                <x-special-sponsorships.type-card
                    label="{{ $type_boter_meseca['label'] }}"
                    link="{{ $type_boter_meseca['formLink'] }}"
                >
                    <x-slot name="description_short">
                        Z donacijo <strong>{{ $type_boter_meseca['amount'] }} €</strong> postanete boter
                        tekočega meseca in tako
                        pomagate preživeti izbrani mesec vsem muckom, ki so takrat v oskrbi Mačje hiše. V zameno
                        za vašo donacijo boste prejeli
                        <strong>ozadje za namizje s koledarjem "vašega" meseca</strong>.
                        Verjamemo, da vam bo vsakodnevni pogled nanj pogosto izvabil nasmeh na obraz in tako
                        tudi vam polepšal izbrani mesec.
                    </x-slot>
                </x-special-sponsorships.type-card>

                <x-special-sponsorships.type-card
                    label="{{ $type_muc_gre_brez_skrbi_v_nove_dni['label'] }}"
                    link="{{ $type_muc_gre_brez_skrbi_v_nove_dni['formLink'] }}"
                >
                    <x-slot name="description_short">
                        Z donacijo
                        <strong>{{ $type_muc_gre_brez_skrbi_v_nove_dni['amount'] }} €</strong>
                        pokrijete stroške kastracije enega mačka.
                    </x-slot>
                </x-special-sponsorships.type-card>

                <x-special-sponsorships.type-card
                    label="{{ $type_muca_gre_brez_skrbi_v_nove_dni['label'] }}"
                    link="{{ $type_muca_gre_brez_skrbi_v_nove_dni['formLink'] }}"
                >
                    <x-slot name="description_short">
                        Z donacijo
                        <strong>{{ $type_muca_gre_brez_skrbi_v_nove_dni['amount'] }} €</strong>
                        pokrijete stroške sterilizacije ene mačke.
                    </x-slot>
                </x-special-sponsorships.type-card>

                <x-special-sponsorships.type-card
                    label="{{ $type_nov_zacetek['label'] }}"
                    link="{{ $type_nov_zacetek['formLink'] }}"
                >
                    <x-slot name="description_short">
                        Z donacijo
                        <strong>{{ $type_nov_zacetek['amount'] }} €</strong>
                        enemu mucku zagotovite pregled, razparazitenje,
                        cepljenje proti kužnim boleznim, testiranje na FELV in FIV, čipiranje,
                        izdajo potnega lista in vnos v register
                    </x-slot>
                </x-special-sponsorships.type-card>

                <div>
                    <h2 class="mb-content-section-title">FIP bojevniki</h2>
                    <div class="mb-typography-content-base">
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
                </div>

                <x-special-sponsorships.type-card
                    label="{{ $type_fip_bojevnik_za_1_dan['label'] }}"
                    link="{{ $type_fip_bojevnik_za_1_dan['formLink'] }}"
                >
                    <x-slot name="description_short">
                        Z donacijo
                        <strong>{{ $type_fip_bojevnik_za_1_dan['amount'] }} €</strong>
                        enemu FIP bojevniku omogočite zdravilo za en dan. V zahvalo vi ali
                        vaš obdarovanec prejmete elektronsko potrdilo/diplomo FIP bojevnik. V primeru, da v času
                        vašega botrstva zdravimo katerega od muckov, vas obvestimo o tem, komu smo namenili
                        botrstvo in kako poteka zdravljenje.
                    </x-slot>
                </x-special-sponsorships.type-card>

                <x-special-sponsorships.type-card
                    label="{{ $type_fip_bojevnik_za_2_dni['label'] }}"
                    link="{{ $type_fip_bojevnik_za_2_dni['formLink'] }}"
                >
                    <x-slot name="description_short">
                        Z donacijo
                        <strong>{{ $type_fip_bojevnik_za_2_dni['amount'] }} €</strong>
                        enemu FIP bojevniku omogočite zdravilo za dva dni. V zahvalo vi ali
                        vaš obdarovanec prejmete elektronsko potrdilo/diplomo FIP bojevnik. V primeru, da v času
                        vašega botrstva zdravimo katerega od muckov, vas obvestimo o tem, komu smo namenili
                        botrstvo in kako poteka zdravljenje.
                    </x-slot>
                </x-special-sponsorships.type-card>

                <x-special-sponsorships.type-card
                    label="{{ $type_fip_bojevnik_za_1_teden['label'] }}"
                    link="{{ $type_fip_bojevnik_za_1_teden['formLink'] }}"
                >
                    <x-slot name="description_short">
                        Z donacijo
                        <strong>{{ $type_fip_bojevnik_za_1_teden['amount'] }} €</strong>
                        enemu FIP bojevniku omogočite en teden zdravljenja, kar pomeni 1/12
                        vseh stroškov zdravljenja za enega muca. V zahvalo vi ali vaš obdarovanec prejmete
                        elektronsko potrdilo/diplomo FIP bojevnik, za dve leti vas (ga) uvrstimo med redne botre
                        mucka Čombeta in prejemate vse, kar prejemajo mačji botri (pisma muckov, voščilo dostop
                        do mesečnih namizij ...). V primeru, da v času vašega botrstva zdravimo katerega od
                        muckov, vas obvestimo o tem, komu smo namenili botrstvo in kako poteka zdravljenje.
                    </x-slot>
                </x-special-sponsorships.type-card>
            </div>
            <div class="col-span-1 lg:col-span-2 lg:col-start-5">
                <x-special-sponsorships.sponsors-of-this-month></x-special-sponsorships.sponsors-of-this-month>
            </div>
        </div>
    </div>
@endsection
