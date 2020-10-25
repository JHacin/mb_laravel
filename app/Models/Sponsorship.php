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
 * @property int $cat_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Cat $cat
 * @property-read User $user
 * @method static Builder|Sponsorship newModelQuery()
 * @method static Builder|Sponsorship newQuery()
 * @method static Builder|Sponsorship query()
 * @method static Builder|Sponsorship whereCatId($value)
 * @method static Builder|Sponsorship whereCreatedAt($value)
 * @method static Builder|Sponsorship whereId($value)
 * @method static Builder|Sponsorship whereUpdatedAt($value)
 * @method static Builder|Sponsorship whereUserId($value)
 * @mixin Eloquent
 */
class Sponsorship extends Model
{
    use CrudTrait;

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
     * Get the user in this sponsorship.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
