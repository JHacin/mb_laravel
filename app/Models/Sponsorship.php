<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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
 * @property-read Cat|null $cat
 * @property-read PersonData|null $personData
 * @method static Builder|Sponsorship newModelQuery()
 * @method static Builder|Sponsorship newQuery()
 * @method static Builder|Sponsorship query()
 * @method static Builder|Sponsorship whereCatId($value)
 * @method static Builder|Sponsorship whereCreatedAt($value)
 * @method static Builder|Sponsorship whereId($value)
 * @method static Builder|Sponsorship wherePersonDataId($value)
 * @method static Builder|Sponsorship whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Sponsorship extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const ATTR__CAT = 'cat';
    public const ATTR__CAT_ID = 'cat_id';
    public const ATTR__PERSON_DATA = 'personData';
    public const ATTR__PERSON_DATA_ID = 'person_data_id';
    public const ATTR__MONTHLY_AMOUNT = 'monthly_amount';
    public const ATTR__IS_ANONYMOUS = 'is_anonymous';

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sponsorships';
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
