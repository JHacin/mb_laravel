<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\SpecialSponsorship
 *
 * @property int $id
 * @property int|null $type
 * @property int|null $sponsor_id
 * @property int|null $payer_id
 * @property int $is_gift
 * @property string|null $confirmed_at
 * @property int $is_anonymous
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $type_label
 * @property-read PersonData|null $payer
 * @property-read PersonData|null $sponsor
 * @method static Builder|SpecialSponsorship newModelQuery()
 * @method static Builder|SpecialSponsorship newQuery()
 * @method static Builder|SpecialSponsorship query()
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
class SpecialSponsorship extends Model
{
    use CrudTrait, HasFactory;

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

    public const TYPES = [
        self::TYPE_BOTER_MESECA,
        self::TYPE_MUC_GRE_BREZ_SKRBI_V_NOVE_DNI,
        self::TYPE_MUCA_GRE_BREZ_SKRBI_V_NOVE_DNI,
        self::TYPE_NOV_ZACETEK,
        self::TYPE_FIP_BOJEVNIK_ZA_1_DAN,
        self::TYPE_FIP_BOJEVNIK_ZA_2_DNI,
        self::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN,
    ];

    public const TYPE_LABELS = [
        self::TYPE_BOTER_MESECA => 'Mesečno botrstvo',
        self::TYPE_MUC_GRE_BREZ_SKRBI_V_NOVE_DNI => 'Muc gre brez skrbi v nove dni',
        self::TYPE_MUCA_GRE_BREZ_SKRBI_V_NOVE_DNI => 'Muca gre brez skrbi v nove dni',
        self::TYPE_NOV_ZACETEK => 'Nov začetek',
        self::TYPE_FIP_BOJEVNIK_ZA_1_DAN => 'FIP bojevnik za en dan',
        self::TYPE_FIP_BOJEVNIK_ZA_2_DNI => 'FIP bojevnik za dva dni',
        self::TYPE_FIP_BOJEVNIK_ZA_1_TEDEN => 'FIP bojevnik za en teden',
    ];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'special_sponsorships';
    protected $guarded = ['id'];

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


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
