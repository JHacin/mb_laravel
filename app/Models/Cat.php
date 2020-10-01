<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Cat
 *
 * @property int $id
 * @property string $name
 * @property int $gender
 * @property string|null $story
 * @property string $date_of_arrival
 * @property string $date_of_birth
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Cat newModelQuery()
 * @method static Builder|Cat newQuery()
 * @method static Builder|Cat query()
 * @method static Builder|Cat whereCreatedAt($value)
 * @method static Builder|Cat whereId($value)
 * @method static Builder|Cat whereName($value)
 * @method static Builder|Cat whereUpdatedAt($value)
 * @method static Builder|Cat whereDateOfArrival($value)
 * @method static Builder|Cat whereDateOfBirth($value)
 * @method static Builder|Cat whereGender($value)
 * @method static Builder|Cat whereIsActive($value)
 * @method static Builder|Cat whereStory($value)
 * @mixin Eloquent
 * @property-read Collection|Sponsorship[] $sponsorships
 * @property-read int|null $sponsorships_count
 * @property-read string $name_and_id
 */
class Cat extends Model
{
    use CrudTrait;

    public const GENDER_UNKNOWN = 0;
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    public const GENDER_LABELS = [
        self::GENDER_UNKNOWN => 'Neznano',
        self::GENDER_MALE => 'Samec',
        self::GENDER_FEMALE => 'Samica',
    ];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'cats';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_of_arrival' => 'date',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Convert the stored integer to a label shown to the user.
     *
     * @return string
     */
    public function getGenderLabel()
    {
        return self::GENDER_LABELS[$this->gender];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the sponsorships that include this cat.
     *
     * @return HasMany
     */
    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
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

    /**
     * Returns the name followed by the ID enclosed in parentheses.
     *
     * @return string
     */
    public function getNameAndIdAttribute() {
        return sprintf('%s (%d)', $this->name, $this->id);
    }

    /**
     * Identifiable attribute for Backpack (in selects).
     *
     * @return string
     */
    public function identifiableAttribute()
    {
        return 'name_and_id';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
