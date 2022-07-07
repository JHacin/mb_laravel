@php
    use App\Models\SpecialSponsorship;
    use JetBrains\PhpStorm\ArrayShape;

    function formLink(int $type): string
    {
        return route('special_sponsorships_form', ['tip' => $type]);
    }

    function makeTypeVars(int $type): array {
        return [
            'label' => SpecialSponsorship::TYPE_LABELS[$type],
            'amount' => SpecialSponsorship::TYPE_AMOUNTS[$type],
            'thumbnail' => SpecialSponsorship::getTypeThumbnails()[$type],
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
    $type_majhna_zobna_miska = makeTypeVars(SpecialSponsorship::TYPE_MAJHNA_ZOBNA_MISKA);
    $type_velika_zobna_mis = makeTypeVars(SpecialSponsorship::TYPE_VELIKA_ZOBNA_MIS);
@endphp

<div class="grid grid-cols-3 gap-7">
    <x-special-sponsorships.type-card
            label="{{ $type_boter_meseca['label'] }}"
            link="{{ $type_boter_meseca['formLink'] }}"
            thumbnail="{{ $type_boter_meseca['thumbnail'] }}"
    >
        <x-slot name="description_short">
            Z donacijo <strong>{{ $type_boter_meseca['amount'] }} €</strong> postanete boter
            tekočega meseca in tako
            pomagate preživeti izbrani mesec vsem muckom, ki so takrat v oskrbi Mačje hiše.
        </x-slot>
        <x-slot name="description_long">
            V zameno za donacijo boste vi ali vaš obdarovanec prejeli ozadje za namizje s koledarjem "vašega"
            meseca.
        </x-slot>
    </x-special-sponsorships.type-card>

    <x-special-sponsorships.type-card
            label="{{ $type_muc_gre_brez_skrbi_v_nove_dni['label'] }}"
            link="{{ $type_muc_gre_brez_skrbi_v_nove_dni['formLink'] }}"
            thumbnail="{{ $type_muc_gre_brez_skrbi_v_nove_dni['thumbnail'] }}"
    >
        <x-slot name="description_short">
            Z donacijo
            <strong>{{ $type_muc_gre_brez_skrbi_v_nove_dni['amount'] }} €</strong>
            pokrijete stroške kastracije enega mačka.
        </x-slot>
        <x-slot name="description_long">
            V zameno za donacijo boste vi ali vaš obdarovanec prejeli prirejeno mačje ozadje za namizje, najkasneje
            v
            roku enega meseca pa
            boste prejeli tudi sliko mucka, za katerega je bil porabljen prispevek ter kratko novičko o tem,
            kaj se z mucem dogaja.
        </x-slot>
    </x-special-sponsorships.type-card>

    <x-special-sponsorships.type-card
            label="{{ $type_muca_gre_brez_skrbi_v_nove_dni['label'] }}"
            link="{{ $type_muca_gre_brez_skrbi_v_nove_dni['formLink'] }}"
            thumbnail="{{ $type_muca_gre_brez_skrbi_v_nove_dni['thumbnail'] }}"
    >
        <x-slot name="description_short">
            Z donacijo
            <strong>{{ $type_muca_gre_brez_skrbi_v_nove_dni['amount'] }} €</strong>
            pokrijete stroške sterilizacije ene mačke.
        </x-slot>
        <x-slot name="description_long">
            V zameno za donacijo boste vi ali vaš obdarovanec prejeli prirejeno mačje ozadje za namizje, najkasneje
            v
            roku enega meseca pa
            boste prejeli tudi sliko mucka, za katerega je bil porabljen prispevek ter kratko novičko o tem,
            kaj se z mucem dogaja.
        </x-slot>
    </x-special-sponsorships.type-card>

    <x-special-sponsorships.type-card
            label="{{ $type_nov_zacetek['label'] }}"
            link="{{ $type_nov_zacetek['formLink'] }}"
            thumbnail="{{ $type_nov_zacetek['thumbnail'] }}"
    >
        <x-slot name="description_short">
            Z donacijo
            <strong>{{ $type_nov_zacetek['amount'] }} €</strong>
            enemu mucku zagotovite pregled, razparazitenje,
            cepljenje proti kužnim boleznim, testiranje na FELV in FIV, čipiranje,
            izdajo potnega lista in vnos v register.
        </x-slot>
        <x-slot name="description_long">
            <div>
                V zameno za donacijo boste vi ali vaš obdarovanec najkasneje v
                roku enega meseca prejeli sliko mucka, kateremu smo omogočili nov začetek ter kratko
                novičko o tem, kaj se z muckom dogaja.
            </div>
            <div class="mt-2">
                Prav tako boste eno leto prejemali vse,
                kar prejemajo stalni mačji botri Bubijev (pisma muckov, voščilo, dostop do
                mesečnih namizij, ...), obveščeni pa boste tudi o vseh pomembnih dogodkih v zvezi z
                mucko, ki ste ji pomagali.
            </div>
        </x-slot>
    </x-special-sponsorships.type-card>
    {{--    </div>--}}

    {{--    <div class="bg-gray-extralight border-t border-gray-light border-dashed px-5 pt-7 pb-8">--}}
    {{--        <h2 class="mb-content-section-title mb-6">FIP bojevniki</h2>--}}
    {{--        <div class="space-y-4">--}}
    {{--            <div>--}}
    {{--                FIP bojevniki so mucki, oboleli za do pred kratkim smrtnonosno boleznijo--}}
    {{--                <strong>mačjega infekcioznega peritonitisa</strong> (Feline Infectious Peritonitis ali FIP).--}}
    {{--            </div>--}}
    {{--            <div>--}}
    {{--                Ob postavljeni diagnozi smo še nedavno--}}
    {{--                vedeli, da je mucek obsojen na smrt. Sedaj je FIP postal ozdravljiv, zdravilo zanj dostopno, je--}}
    {{--                pa zdravljenje dolgotrajno in zaenkrat še zelo drago.--}}
    {{--            </div>--}}
    {{--            <div>--}}
    {{--                Mačji FIP bojevnik prejema zdravila vsaj 12 tednov (84 dni), ob tem potrebuje redne kontrole in--}}
    {{--                vitaminsko podporo.--}}
    {{--                Odmerek zdravila se--}}
    {{--                prilagaja glede na težo mucka in obliko bolezni, v povprečju pa znaša strošek zdravljenja 25--}}
    {{--                evrov na dan.--}}
    {{--            </div>--}}
    {{--            <div>--}}
    {{--                Zaradi visokih stroškov je botrstvo FIP bojevnik vseskozi aktivno, tudi takrat, ko--}}
    {{--                noben muc ni bolan, saj želimo vsem našim muckom v prihodnje omogočiti zdravljenje. Zato zanje--}}
    {{--                ustanavljamo poseben FIP sklad. Z botrstvom tako pomagate enemu trenutnemu ali bodočemu FIP--}}
    {{--                bojevniku na njegovi poti do FIP zmagovalca.--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{--    <div>--}}
    <x-special-sponsorships.type-card
            label="{{ $type_fip_bojevnik_za_1_dan['label'] }}"
            link="{{ $type_fip_bojevnik_za_1_dan['formLink'] }}"
            thumbnail="{{ $type_fip_bojevnik_za_1_dan['thumbnail'] }}"
    >
        <x-slot name="description_short">
            Z donacijo
            <strong>{{ $type_fip_bojevnik_za_1_dan['amount'] }} €</strong>
            enemu FIP bojevniku omogočite zdravilo za en dan.
        </x-slot>
        <x-slot name="description_long">
            <div>
                V zahvalo vi ali
                vaš obdarovanec prejmete elektronsko potrdilo/diplomo FIP bojevnik.
            </div>
            <div class="mt-2">
                V primeru, da v času
                vašega botrstva zdravimo katerega od muckov, vas obvestimo o tem, komu smo namenili
                botrstvo in kako poteka zdravljenje.
            </div>
        </x-slot>
    </x-special-sponsorships.type-card>

    <x-special-sponsorships.type-card
            label="{{ $type_fip_bojevnik_za_2_dni['label'] }}"
            link="{{ $type_fip_bojevnik_za_2_dni['formLink'] }}"
            thumbnail="{{ $type_fip_bojevnik_za_2_dni['thumbnail'] }}"
    >
        <x-slot name="description_short">
            Z donacijo
            <strong>{{ $type_fip_bojevnik_za_2_dni['amount'] }} €</strong>
            enemu FIP bojevniku omogočite zdravilo za dva dni.
        </x-slot>
        <x-slot name="description_long">
            <div>
                V zahvalo vi ali
                vaš obdarovanec prejmete elektronsko potrdilo/diplomo FIP bojevnik.
            </div>
            <div class="mt-2">
                V primeru, da v času
                vašega botrstva zdravimo katerega od muckov, vas obvestimo o tem, komu smo namenili
                botrstvo in kako poteka zdravljenje.
            </div>
        </x-slot>
    </x-special-sponsorships.type-card>

    <x-special-sponsorships.type-card
            label="{{ $type_fip_bojevnik_za_1_teden['label'] }}"
            link="{{ $type_fip_bojevnik_za_1_teden['formLink'] }}"
            thumbnail="{{ $type_fip_bojevnik_za_1_teden['thumbnail'] }}"
    >
        <x-slot name="description_short">
            Z donacijo
            <strong>{{ $type_fip_bojevnik_za_1_teden['amount'] }} €</strong>
            enemu FIP bojevniku omogočite en teden zdravljenja, kar pomeni 1/12
            vseh stroškov zdravljenja za enega muca.
        </x-slot>
        <x-slot name="description_long">
            <div>
                V zahvalo vi ali vaš obdarovanec prejmete
                elektronsko potrdilo/diplomo FIP bojevnik.
            </div>
            <div class="mt-2">
                Poleg tega za dve leti prejemate vse, kar prejemajo
                mačji botri (pisma muckov, voščilo, dostop
                do mesečnih namizij, ...).
            </div>
            <div class="mt-2">
                V primeru, da v času vašega botrstva zdravimo katerega od
                muckov, vas obvestimo o tem, komu smo namenili botrstvo in kako poteka zdravljenje.
            </div>
        </x-slot>
    </x-special-sponsorships.type-card>

    <x-special-sponsorships.type-card
            label="{{ $type_majhna_zobna_miska['label'] }}"
            link="{{ $type_majhna_zobna_miska['formLink'] }}"
            thumbnail="{{ $type_majhna_zobna_miska['thumbnail'] }}"
    >
        <x-slot name="description_short">
            Z donacijo <strong>{{ $type_majhna_zobna_miska['amount'] }} €</strong> krijete stroške čiščenja zobnega
            kamna in/ali manjšega zobnega posega.
        </x-slot>
        <x-slot name="description_long">
            <div>
                Z botrstvom se za
                eno leto uvrstite med botre Čombeta in prejemate vse, kar prejemajo stalni botri.
            </div>
            <div class="mt-2">
                V primeru, da botrstvo
                podarite, v vašem imenu in z vašim besedilom obdarovancu pošljemo osebno prilagojeno elektronsko
                voščilnico
                in ga uvrstimo med botre za eno leto.
            </div>
            <div class="mt-2">
                V obdobju treh mesecev vi ali obdarovanec prejmete podatke in sliko
                mucka, ki ga je s pomočjo botrstva obiskala zobna miška.
            </div>
        </x-slot>
    </x-special-sponsorships.type-card>

    <x-special-sponsorships.type-card
            label="{{ $type_velika_zobna_mis['label'] }}"
            link="{{ $type_velika_zobna_mis['formLink'] }}"
            thumbnail="{{ $type_velika_zobna_mis['thumbnail'] }}"
    >
        <x-slot name="description_short">
            Z donacijo <strong>{{ $type_velika_zobna_mis['amount'] }} €</strong> krijete stroške enega večjega zobnega
            posega ali dveh manjših.
        </x-slot>
        <x-slot name="description_long">
            <div>
                Z botrstvom se za eno leto uvrstite med botre Čombeta (ali drugega mucka, ki je na voljo za botrovanje)
                in prejemate vse, kar prejemajo stalni botri.
            </div>
            <div class="mt-2">
                V primeru, da botrstvo podarite, v vašem imenu in z vašim besedilom obdarovancu pošljemo osebno
                prilagojeno elektronsko voščilnico in ga uvrstimo med botre za eno leto.
            </div>
            <div class="mt-2">
                V obdobju treh mesecev vi ali obdarovanec prejmete podatke in sliko mucka, ki ga (ju) je s pomočjo
                botrstva obiskala zobna miška.
            </div>
        </x-slot>
    </x-special-sponsorships.type-card>
</div>
