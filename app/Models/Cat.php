<?php

namespace App\Models;

use App\Models\Traits\ClearsGlobalScopes;
use App\Services\CatPhotoService;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $gender
 * @property string|null $story
 * @property Carbon|null $date_of_arrival_mh
 * @property Carbon|null $date_of_birth
 * @property bool $is_active
 * @property int|null $location_id
 * @property string $slug
 * @property Carbon|null $date_of_arrival_boter
 * @property-read string $first_photo_url
 * @property-read string $gender_label
 * @property-read string $name_and_id
 * @property-read CatLocation|null $location
 * @property-read Collection|CatPhoto[] $photos
 * @property-read int|null $photos_count
 * @property-read Collection|Sponsorship[] $sponsorships
 * @property-read int|null $sponsorships_count
 * @method static Builder|Cat newModelQuery()
 * @method static Builder|Cat newQuery()
 * @method static Builder|Cat query()
 * @method static Builder|Cat whereCreatedAt($value)
 * @method static Builder|Cat whereDateOfArrivalBoter($value)
 * @method static Builder|Cat whereDateOfArrivalMh($value)
 * @method static Builder|Cat whereDateOfBirth($value)
 * @method static Builder|Cat whereGender($value)
 * @method static Builder|Cat whereId($value)
 * @method static Builder|Cat whereIsActive($value)
 * @method static Builder|Cat whereLocationId($value)
 * @method static Builder|Cat whereName($value)
 * @method static Builder|Cat whereSlug($value)
 * @method static Builder|Cat whereStory($value)
 * @method static Builder|Cat whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Cat extends Model
{
    use HasFactory, CrudTrait, HasSlug, ClearsGlobalScopes;

    /*
    |--------------------------------------------------------------------------
    | CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const GENDER_UNKNOWN = 0;
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    public const GENDERS = [
        self::GENDER_UNKNOWN,
        self::GENDER_MALE,
        self::GENDER_FEMALE,
    ];

    public const GENDER_LABELS = [
        self::GENDER_UNKNOWN => 'neznano',
        self::GENDER_MALE => 'samec',
        self::GENDER_FEMALE => 'samica',
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
        'date_of_birth' => 'date',
        'date_of_arrival_mh' => 'date',
        'date_of_arrival_boter' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Used in Backpack when showing the model instance label via relationship inputs.
     *
     * @var string
     */
    protected string $identifiableAttribute = 'name_and_id';

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

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
     * @inheritDoc
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param int $index
     * @return CatPhoto|null
     */
    public function getPhotoByIndex(int $index): ?CatPhoto
    {
        /** @var CatPhoto $photo */
        $photo = $this->photos()->where('index', $index)->first();

        return $photo;
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
    public function sponsorships(): HasMany
    {
        return $this->hasMany(Sponsorship::class);
    }

    /**
     * Get the location this cat is on.
     *
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(CatLocation::class);
    }

    /**
     * Get this cat's photos.
     *
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(CatPhoto::class);
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

    /**
     * Convert the stored integer to a label shown to the user.
     *
     * @return string
     */
    public function getGenderLabelAttribute(): string
    {
        return self::GENDER_LABELS[$this->gender];
    }

    /**
     * Finds the first photo it can, and returns its URL, otherwise an empty string.
     *
     * @return string
     */
    public function getFirstPhotoUrlAttribute(): string
    {
        foreach (CatPhotoService::INDICES as $index) {
            $photo = self::getPhotoByIndex($index);

            if ($photo) {
                return $photo->url;
            }
        }

        return CatPhotoService::getPlaceholderImage();
    }

    /**
     * Returns the name followed by the ID enclosed in parentheses.
     *
     * @return string
     */
    public function getNameAndIdAttribute(): string
    {
        return sprintf('%s (%d)', $this->name, $this->id);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
