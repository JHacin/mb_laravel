<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Database\Factories\SpecialSponsorshipFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Venturecraft\Revisionable\Revision;
use Venturecraft\Revisionable\RevisionableTrait;


/**
 * App\Models\SpecialSponsorship
 *
 * @property int $id
 * @property int|null $type
 * @property int|null $sponsor_id
 * @property int|null $payer_id
 * @property bool $is_gift
 * @property Carbon|null $confirmed_at
 * @property bool $is_anonymous
 * @property string|null $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $payment_purpose
 * @property-read string $payment_reference_number
 * @property-read string $type_label
 * @property-read PersonData|null $payer
 * @property-read Collection|Revision[] $revisionHistory
 * @property-read int|null $revision_history_count
 * @property-read PersonData|null $sponsor
 * @method static SpecialSponsorshipFactory factory(...$parameters)
 * @method static Builder|SpecialSponsorship newModelQuery()
 * @method static Builder|SpecialSponsorship newQuery()
 * @method static Builder|SpecialSponsorship query()
 * @method static Builder|SpecialSponsorship whereAmount($value)
 * @method static Builder|SpecialSponsorship whereConfirmedAt($value)
 * @method static Builder|SpecialSponsorship whereCreatedAt($value)
 * @method static Builder|SpecialSponsorship whereId($value)
 * @method static Builder|SpecialSponsorship whereIsAnonymous($value)
 * @method static Builder|SpecialSponsorship whereIsGift($value)
 * @method static Builder|SpecialSponsorship wherePayerId($value)
 * @method static Builder|SpecialSponsorship whereSponsorId($value)
 * @method static Builder|SpecialSponsorship whereType($value)
 * @method static Builder|SpecialSponsorship whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SpecialSponsorship extends Model implements BankTransferFields
{
    use CrudTrait, RevisionableTrait, HasFactory;

    /*
    |--------------------------------------------------------------------------
    | CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const TYPE_BOTER_MESECA = 1;
    public const TYPE_MUC_GRE_BREZ_SKRBI_V_NOVE_DNI = 2;
    public const TYPE_MUCA_GRE_BREZ_SKRBI_V_NOVE_DNI = 3;
    public const TYPE_NOV_ZACETEK = 4;
    public const TYPE_FIP_BOJEVNIK_ZA_1_DAN = 5;
    public const TYPE_FIP_BOJEVNIK_ZA_2_DNI = 6;
    public const TYPE_FIP_BOJEVNIK_ZA_1_TEDEN = 7;
    public const TYPE_MAJHNA_ZOBNA_MISKA = 8;
    public const TYPE_VELIKA_ZOBNA_MIS = 9;

    public const TYPES = [
        self::TYPE_BOTER_MESECA,
        self::TYPE_MUC_GRE_BREZ_SKRBI_V_NOVE_DNI,
        self::TYPE_MUCA_GRE_BREZ_SKRBI_V_NOVE_DNI,
        self::TYPE_NOV_ZACETEK,
        self::TYPE_FIP_BOJEVNIK_ZA_1_DAN,
        self::TYPE_FIP_BOJEVNIK_ZA_2_DNI,
        self::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN,
        self::TYPE_MAJHNA_ZOBNA_MISKA,
        self::TYPE_VELIKA_ZOBNA_MIS,
    ];

    public const TYPE_LABELS = [
        self::TYPE_BOTER_MESECA => 'Mesečno botrstvo',
        self::TYPE_MUC_GRE_BREZ_SKRBI_V_NOVE_DNI => 'Muc gre brez skrbi v nove dni',
        self::TYPE_MUCA_GRE_BREZ_SKRBI_V_NOVE_DNI => 'Muca gre brez skrbi v nove dni',
        self::TYPE_NOV_ZACETEK => 'Nov začetek',
        self::TYPE_FIP_BOJEVNIK_ZA_1_DAN => 'FIP bojevnik za en dan',
        self::TYPE_FIP_BOJEVNIK_ZA_2_DNI => 'FIP bojevnik za dva dni',
        self::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN => 'FIP bojevnik za en teden',
        self::TYPE_MAJHNA_ZOBNA_MISKA => 'Majhna zobna miška',
        self::TYPE_VELIKA_ZOBNA_MIS => 'Velika zobna miš',
    ];

    public const TYPE_AMOUNTS = [
        self::TYPE_BOTER_MESECA => 10,
        self::TYPE_MUC_GRE_BREZ_SKRBI_V_NOVE_DNI => 25,
        self::TYPE_MUCA_GRE_BREZ_SKRBI_V_NOVE_DNI => 35,
        self::TYPE_NOV_ZACETEK => 60,
        self::TYPE_FIP_BOJEVNIK_ZA_1_DAN => 25,
        self::TYPE_FIP_BOJEVNIK_ZA_2_DNI => 50,
        self::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN => 175,
        self::TYPE_MAJHNA_ZOBNA_MISKA => 60,
        self::TYPE_VELIKA_ZOBNA_MIS => 120,
    ];

    public const TYPE_THUMBNAILS = [
        self::TYPE_BOTER_MESECA => "https://scontent.flju1-1.fna.fbcdn.net/v/t39.30808-6/217467454_10159433656342463_599096892114515202_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=e3f864&_nc_ohc=3gkqu_38QisAX9Dy1Mn&_nc_ht=scontent.flju1-1.fna&oh=00_AT8cUWsq0mWv-3U-zEi6D9JHcwv0zlhzYnp8DIqAidiNOg&oe=62C4280B",
        self::TYPE_MUC_GRE_BREZ_SKRBI_V_NOVE_DNI => "https://scontent.flju1-1.fna.fbcdn.net/v/t39.30808-6/242144971_10159570580692463_5072366520309478561_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=e3f864&_nc_ohc=ocjOUaIb8XAAX8lij_m&_nc_ht=scontent.flju1-1.fna&oh=00_AT8N2kpQ91X53CRT5IgeG1pwWJXlMaHPZ0F6UPNvSvw8wA&oe=62C4C900",
        self::TYPE_MUCA_GRE_BREZ_SKRBI_V_NOVE_DNI => "https://scontent.flju1-1.fna.fbcdn.net/v/t39.30808-6/276319163_10159912742342463_959089635915175336_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=e3f864&_nc_ohc=Yy_D4gI7LtwAX-4LjGw&tn=2NX2vWxeNPT1kJeY&_nc_ht=scontent.flju1-1.fna&oh=00_AT8bR1i-4b1zZYmRgu8Htu1jsPoESugb6bNUgzrwb5GU3w&oe=62C36D4C",
        self::TYPE_NOV_ZACETEK => "https://scontent.flju1-1.fna.fbcdn.net/v/t1.6435-9/70747631_10157578485662463_612970924961955840_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=e3f864&_nc_ohc=0-vfA7XvE8AAX-Fdg4W&_nc_ht=scontent.flju1-1.fna&oh=00_AT-_iJzE6BBRuLEYmNYy57tjwDcXtg3hzBY2HUrkGv_1Ag&oe=62E47903",
        self::TYPE_FIP_BOJEVNIK_ZA_1_DAN => "https://scontent.flju1-1.fna.fbcdn.net/v/t39.30808-6/240238387_10159519380932463_4799160857698656272_n.jpg?_nc_cat=103&ccb=1-7&_nc_sid=e3f864&_nc_ohc=A2-jk2tpr3UAX96riHE&_nc_ht=scontent.flju1-1.fna&oh=00_AT9GxPkz2UI6uOPWb0tDQF_9nidGEbNTJhLTIgnqrMlXCg&oe=62C503DD",
        self::TYPE_FIP_BOJEVNIK_ZA_2_DNI => "https://scontent.flju1-1.fna.fbcdn.net/v/t39.30808-6/283477057_10160011165477463_2613175149054903094_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=e3f864&_nc_ohc=cIhLS0ei_-sAX_u0Lci&tn=2NX2vWxeNPT1kJeY&_nc_ht=scontent.flju1-1.fna&oh=00_AT9iTxznrSdRLLQmNXwiuczFBpPrJAXthjRgD6BGYL3T1g&oe=62C72F80",
        self::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN => "https://scontent.flju1-1.fna.fbcdn.net/v/t1.6435-9/79376211_10157778347582463_7337357884642033664_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=e3f864&_nc_ohc=UGyxodM4Tg8AX_bJ6nm&_nc_ht=scontent.flju1-1.fna&oh=00_AT8Qe_hr7PvIoiyxf76PQC6wp0TB_crnv6UpchEaBNW84g&oe=62E576F4",
        self::TYPE_MAJHNA_ZOBNA_MISKA => "https://scontent.flju1-1.fna.fbcdn.net/v/t1.6435-9/168639726_10159217888212463_1757997775375579923_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=e3f864&_nc_ohc=_4IEri__g8gAX9aoqo9&_nc_ht=scontent.flju1-1.fna&oh=00_AT81s-5z8LAarVNFAWO3pNRt40Y81S31UjdP49DxeEWUjA&oe=62E7BE60",
        self::TYPE_VELIKA_ZOBNA_MIS => "https://scontent.flju1-1.fna.fbcdn.net/v/t1.6435-9/90235714_10158121706052463_7186357559048011776_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=e3f864&_nc_ohc=n_hVLq9wYVEAX9rA69j&_nc_oc=AQmfFX6P981QDdjJNg1oTd4HBuOXpqBvj4GeSOyJtNA99HZ7WTB9SPKtWo4I3n4PBI4&_nc_ht=scontent.flju1-1.fna&oh=00_AT9M180oA2EL_EcrYsbqkxhql4NPY3C47bUP2bJb7wi8BQ&oe=62E991D2",
    ];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'special_sponsorships';
    protected $guarded = ['id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_gift' => 'boolean',
        'confirmed_at' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(PersonData::class, 'sponsor_id');
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(PersonData::class, 'payer_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type];
    }

    public function getPaymentPurposeAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] . ' - ' . $this->sponsor->last_name;
    }

    public function getPaymentReferenceNumberAttribute(): string
    {
        return 'SI00 80-1' . $this->type . '-' . $this->id;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | CRUD-RELATED FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function identifiableName(): string
    {
        return $this->id;
    }
}
