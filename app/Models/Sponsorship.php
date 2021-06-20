<?php

namespace App\Models;

use App\Models\Traits\ClearsGlobalScopes;
use App\Utilities\BankTransferFieldGenerator;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Sponsorship
 *
 * @property int $id
 * @property int|null $cat_id
 * @property int|null $person_data_id
 * @property int|null $payer_id
 * @property int $is_gift
 * @property bool $is_anonymous
 * @property int $payment_type
 * @property string|null $monthly_amount
 * @property bool $is_active
 * @property Carbon|null $ended_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Cat|null $cat
 * @property-read string $payment_reference_number
 * @property-read PersonData|null $personData
 * @property-read PersonData|null $payer
 * @method static Builder|Sponsorship newModelQuery()
 * @method static Builder|Sponsorship newQuery()
 * @method static Builder|Sponsorship query()
 * @method static Builder|Sponsorship whereCatId($value)
 * @method static Builder|Sponsorship whereCreatedAt($value)
 * @method static Builder|Sponsorship whereEndedAt($value)
 * @method static Builder|Sponsorship whereId($value)
 * @method static Builder|Sponsorship whereIsActive($value)
 * @method static Builder|Sponsorship whereIsGift($value)
 * @method static Builder|Sponsorship whereIsAnonymous($value)
 * @method static Builder|Sponsorship whereMonthlyAmount($value)
 * @method static Builder|Sponsorship wherePaymentType($value)
 * @method static Builder|Sponsorship wherePersonDataId($value)
 * @method static Builder|Sponsorship wherePayerId($value)
 * @method static Builder|Sponsorship whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Sponsorship extends Model
{
    use HasFactory, CrudTrait, ClearsGlobalScopes;

    /*
    |--------------------------------------------------------------------------
    | CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const PAYMENT_TYPE_BANK_TRANSFER = 1;
    public const PAYMENT_TYPE_DIRECT_DEBIT = 2;

    public const PAYMENT_TYPES = [
      self::PAYMENT_TYPE_BANK_TRANSFER,
      self::PAYMENT_TYPE_DIRECT_DEBIT,
    ];

    public const PAYMENT_TYPE_LABELS = [
        self::PAYMENT_TYPE_BANK_TRANSFER => 'Nakazilo',
        self::PAYMENT_TYPE_DIRECT_DEBIT => 'Trajnik',
    ];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sponsorships';
    protected $guarded = ['id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'ended_at' => 'date',
        'is_anonymous' => 'boolean',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return void
     */
    public function cancel()
    {
        $this->update([
            'is_active' => false,
            'ended_at' => Carbon::now()->toDateString(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function cat(): BelongsTo
    {
        return $this->belongsTo(Cat::class);
    }

    public function personData(): BelongsTo
    {
        return $this->belongsTo(PersonData::class);
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(PersonData::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * @inheritDoc
     */
    protected static function booted()
    {
        static::addGlobalScope('is_active', function (Builder $builder) {
            $builder->where('is_active', true);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getPaymentReferenceNumberAttribute(): string
    {
        return BankTransferFieldGenerator::referenceNumber($this);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
