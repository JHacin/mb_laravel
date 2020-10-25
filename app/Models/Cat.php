<?php

namespace App\Models;

use App\Services\CatPhotoService;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Cat
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $gender
 * @property string|null $story
 * @property string $date_of_arrival
 * @property string $date_of_birth
 * @property int $is_active
 * @property int|null $location_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Sponsorship[] $sponsorships
 * @property-read int|null $sponsorships_count
 * @property-read string $name_and_id
 * @property-read CatLocation|null $location
 * @property-read Collection|CatPhoto[] $photos
 * @property-read int|null $photos_count
 * @property-read string $first_photo_url
 * @method static Builder|Cat newModelQuery()
 * @method static Builder|Cat newQuery()
 * @method static Builder|Cat query()
 * @method static Builder|Cat whereCreatedAt($value)
 * @method static Builder|Cat whereId($value)
 * @method static Builder|Cat whereName($value)
 * @method static Builder|Cat whereSlug($value)
 * @method static Builder|Cat whereUpdatedAt($value)
 * @method static Builder|Cat whereDateOfArrival($value)
 * @method static Builder|Cat whereDateOfBirth($value)
 * @method static Builder|Cat whereGender($value)
 * @method static Builder|Cat whereIsActive($value)
 * @method static Builder|Cat whereStory($value)
 * @method static Builder|Cat whereLocationId($value)
 * @mixin Eloquent
 */
class Cat extends Model
{
    use CrudTrait, HasSlug;

    /*
    |--------------------------------------------------------------------------
    | CONSTANTS
    |--------------------------------------------------------------------------
    */

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
    protected $guarded = ['id'];

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
     * @inheritdoc
     */
    protected static function booted()
    {
        // Only make active Cats visible to the public. This scope is manually cleared in admin.
        static::addGlobalScope('is_active', function (Builder $builder) {
            $builder->where('is_active', true);
        });
    }

    /**
     * Remove global scopes such as only returning cats with is_active=1 (used in admin).
     */
    public function clearGlobalScopes()
    {
        static::$globalScopes = [];
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(30);
    }

    /**
     * @inheritdoc
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    /**
     * Get the location this cat is on.
     *
     * @return BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(CatLocation::class);
    }

    /**
     * Finds the first photo it can, and returns its URL, otherwise an empty string.
     * Todo: replace empty string with some sort of image fallback?
     *
     * @return string
     */
    public function getFirstPhotoUrlAttribute()
    {
        foreach (CatPhotoService::INDICES as $index) {
            $photo = self::getPhotoByIndex($index);

            if ($photo) {
                return $photo->getUrl();
            }
        }

        return CatPhotoService::getPlaceholderImage();
    }

    /**
     * @param int $index
     * @return CatPhoto|null
     */
    public function getPhotoByIndex(int $index)
    {
        /** @var CatPhoto $photo */
        $photo = $this->photos()->where('index', $index)->first();

        return $photo;
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
     * Get this cat's photos.
     *
     * @return HasMany
     */
    public function photos()
    {
        return $this->hasMany(CatPhoto::class);
    }

    /**
     * Returns the name followed by the ID enclosed in parentheses.
     *
     * @return string
     */
    public function getNameAndIdAttribute()
    {
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
