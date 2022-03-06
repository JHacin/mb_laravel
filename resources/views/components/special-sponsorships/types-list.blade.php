@php
use App\Models\SpecialSponsorship;
use JetBrains\PhpStorm\ArrayShape;

$labels = SpecialSponsorship::TYPE_LABELS;
$amounts = SpecialSponsorship::TYPE_AMOUNTS;

function formLink(int $type): string
{
    return route('special_sponsorships_form', ['tip' => $type]);
}

#[
    ArrayShape([
        'label' => 'string',
        'amount' => 'int',
        'formLink' => 'string',
    ]),
]
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

<div class="space-y-6">
    <x-special-sponsorships.type-card
        label="{{ $type_boter_meseca['label'] }}"
        link="{{ $type_boter_meseca['formLink'] }}"
    >
        <x-slot name="description_short">
            Z donacijo <strong>{{ $type_boter_meseca['amount'] }} €</strong> postanete boter
            tekočega meseca in tako
            pomagate preživeti izbrani mesec vsem muckom, ki so takrat v oskrbi Mačje hiše.
        </x-slot>
        <x-slot name="description_long">
            <div>V zameno za vašo donacijo boste prejeli ozadje za namizje s koledarjem "vašega" meseca.</div>
            <div>
                Verjamemo, da vam bo vsakodnevni pogled nanj pogosto izvabil nasmeh na obraz in tako
                tudi vam polepšal izbrani mesec.
            </div>
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
        <x-slot name="description_long">
            <div>
                Obdarovanec bo na izbrani datum prejel prirejeno mačje namizje z napisom
                "Praznujem in obdarujem", na koledarju namizja pa bo posebej označen njegov
                praznični dan.
            </div>
            <div>
                Namizje mu bomo po elektronski pošti poslali v vašem imenu in
                z vašim sporočilom, obdarovanec pa bo dva meseca zapored uvrščen na seznam
                mesečnih botrov.
            </div>
            <div>
                Najkasneje v roku enega meseca bo obdarovanec prejel tudi
                sliko mucka, za katerega je bil porabljen prispevek ter kratko novičko o tem,
                kaj se z mucem dogaja.
            </div>
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
        <x-slot name="description_long">
            <div>
                Obdarovanec bo na izbrani datum po elektronski pošti prejel prirejeno mačje
                namizje z napisom "Praznujem in obdarujem", na koledarju namizja pa bo posebej
                označen njegov praznični dan.
            </div>
            <div>
                Namizje mu bomo poslali v vašem imenu in z vašim
                sporočilom, obdarovanec pa bo tri mesece zapored uvrščen na seznam mesečnih
                botrov.
            </div>
            <div>
                Poleg tega bo obdarovanec najkasneje v roku enega meseca prejel sliko
                mucke, za katero je bil porabljen prispevek ter kratko novičko o tem, kaj se z
                muco dogaja.
            </div>
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
            izdajo potnega lista in vnos v register.
        </x-slot>
        <x-slot name="description_long">
            <div>
                Vašemu obdarovancu bomo v vašem imenu in z vašim sporočilom na izbrani datum
                poslali osebno prilagojeno elektronsko voščilnico. Obdarovanec bo uvrščen na
                seznam botrov Bubijev za obdobje enega leta.
            </div>
            <div>
                Najkasneje v roku enega meseca bo
                obdarovanec prejel sliko mucka, kateremu je omogočil nov začetek ter kratko
                novičko o tem, kaj se z muckom dogaja.
            </div>
            <div>
                Obdarovanec bo eno leto prejemal vse,
                kar prejemajo stalni mačji botri Bubijev (pisma muckov, voščilo, dostop do
                mesečnih namizij ...), obveščen pa bo tudi o vseh pomembnih dogodkih v zvezi z
                mucko, ki ji je pomagal.
            </div>
        </x-slot>
    </x-special-sponsorships.type-card>

    <div class="pt-6">
        <h2 class="mb-content-section-title mb-6">FIP bojevniki</h2>
        <div class="space-y-2">
            <div>
                FIP bojevniki so mucki, oboleli za do pred kratkim smrtnonosno boleznijo
                <strong>mačjega infekcioznega peritonitisa</strong> (Feline Infectious Peritonitis ali FIP).
            </div>
            <div>
                Ob postavljeni diagnozi smo še nedavno
                vedeli, da je mucek obsojen na smrt. Sedaj je FIP postal ozdravljiv, zdravilo zanj dostopno, je
                pa zdravljenje dolgotrajno in zaenkrat še zelo drago.
            </div>
            <div>
                Mačji FIP bojevnik prejema zdravila vsaj 12 tednov (84 dni), ob tem potrebuje redne kontrole in
                vitaminsko podporo.
                Odmerek zdravila se
                prilagaja glede na težo mucka in obliko bolezni, v povprečju pa znaša strošek zdravljenja 25
                evrov na dan.
            </div>
            <div>
                Zaradi visokih stroškov je botrstvo FIP bojevnik vseskozi aktivno, tudi takrat, ko
                noben muc ni bolan, saj želimo vsem našim muckom v prihodnje omogočiti zdravljenje. Zato zanje
                ustanavljamo poseben FIP sklad. Z botrstvom tako pomagate enemu trenutnemu ali bodočemu FIP
                bojevniku na njegovi poti do FIP zmagovalca.
            </div>
        </div>
    </div>

    <x-special-sponsorships.type-card
        label="{{ $type_fip_bojevnik_za_1_dan['label'] }}"
        link="{{ $type_fip_bojevnik_za_1_dan['formLink'] }}"
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
            <div>
                V primeru, da v času
                vašega botrstva zdravimo katerega od muckov, vas obvestimo o tem, komu smo namenili
                botrstvo in kako poteka zdravljenje.
            </div>
        </x-slot>
    </x-special-sponsorships.type-card>

    <x-special-sponsorships.type-card
        label="{{ $type_fip_bojevnik_za_2_dni['label'] }}"
        link="{{ $type_fip_bojevnik_za_2_dni['formLink'] }}"
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
            <div>
                V primeru, da v času
                vašega botrstva zdravimo katerega od muckov, vas obvestimo o tem, komu smo namenili
                botrstvo in kako poteka zdravljenje.
            </div>
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
            vseh stroškov zdravljenja za enega muca.
        </x-slot>
        <x-slot name="description_long">
            <div>
                V zahvalo vi ali vaš obdarovanec prejmete
                elektronsko potrdilo/diplomo FIP bojevnik, za dve leti vas (ga) uvrstimo med redne botre
                mucka Čombeta in prejemate vse, kar prejemajo mačji botri (pisma muckov, voščilo dostop
                do mesečnih namizij ...).
            </div>
            <div>
                V primeru, da v času vašega botrstva zdravimo katerega od
                muckov, vas obvestimo o tem, komu smo namenili botrstvo in kako poteka zdravljenje.
            </div>
        </x-slot>
    </x-special-sponsorships.type-card>
</div>
