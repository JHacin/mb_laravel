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
 * App\Models\Sponsorship
 *
 * @property int $id
 * @property int|null $cat_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $person_data_id
 * @property int $is_anonymous
 * @property string|null $monthly_amount
 * @property int $is_active
 * @property Carbon|null $ended_at
 * @property-read Cat|null $cat
 * @property-read PersonData|null $personData
 * @method static Builder|Sponsorship newModelQuery()
 * @method static Builder|Sponsorship newQuery()
 * @method static Builder|Sponsorship query()
 * @method static Builder|Sponsorship whereCatId($value)
 * @method static Builder|Sponsorship whereCreatedAt($value)
 * @method static Builder|Sponsorship whereEndedAt($value)
 * @method static Builder|Sponsorship whereId($value)
 * @method static Builder|Sponsorship whereIsActive($value)
 * @method static Builder|Sponsorship whereIsAnonymous($value)
 * @method static Builder|Sponsorship whereMonthlyAmount($value)
 * @method static Builder|Sponsorship wherePersonDataId($value)
 * @method static Builder|Sponsorship whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Sponsorship extends Model
{
    use HasFactory, CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | CONSTANTS
    |--------------------------------------------------------------------------
    */

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
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return string[][]
     */
    public static function getSharedValidationRules()
    {
        return [
            'is_anonymous' => ['boolean'],
            'monthly_amount' => ['required', 'numeric', 'between:0,' . config('money.decimal_max')],
        ];
    }

    /**
     * @return array
     */
    public static function getSharedValidationMessages()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the cat in this sponsorship.
     *
     * @return BelongsTo
     */
    public function cat()
    {
        return $this->belongsTo(Cat::class);
    }

    /**
     * Get the person in this sponsorship.
     *
     * @return BelongsTo
     */
    public function personData()
    {
        return $this->belongsTo(PersonData::class);
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
