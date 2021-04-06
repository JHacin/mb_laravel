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
 * @property int|null $gender
 * @property int $status
 * @property string|null $story
 * @property Carbon|null $date_of_arrival_mh
 * @property Carbon|null $date_of_arrival_boter
 * @property Carbon|null $date_of_birth
 * @property int $is_group
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $slug
 * @property int|null $location_id
 * @property-read string $first_photo_url
 * @property-read string $gender_label
 * @property-read string $name_and_id
 * @property-read string $status_label
 * @property-read CatLocation|null $location
 * @property-read Collection|CatPhoto[] $photos
 * @property-read int|null $photos_count
 * @property-read Collection|SponsorshipMessage[] $sponsorshipMessages
 * @property-read int|null $sponsorship_messages_count
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
 * @method static Builder|Cat whereIsGroup($value)
 * @method static Builder|Cat whereLocationId($value)
 * @method static Builder|Cat whereName($value)
 * @method static Builder|Cat whereSlug($value)
 * @method static Builder|Cat whereStatus($value)
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

    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDERS = [
        self::GENDER_MALE,
        self::GENDER_FEMALE,
    ];
    public const GENDER_LABELS = [
        self::GENDER_MALE => 'samček',
        self::GENDER_FEMALE => 'samička',
    ];

    public const STATUS_SEEKING_SPONSORS = 1;
    public const STATUS_TEMP_NOT_SEEKING_SPONSORS = 2;
    public const STATUS_NOT_SEEKING_SPONSORS = 3;
    public const STATUS_ADOPTED = 4;
    public const STATUS_RIP = 5;
    public const STATUSES = [
        self::STATUS_SEEKING_SPONSORS,
        self::STATUS_TEMP_NOT_SEEKING_SPONSORS,
        self::STATUS_NOT_SEEKING_SPONSORS,
        self::STATUS_ADOPTED,
        self::STATUS_RIP,
    ];
    public const STATUS_LABELS = [
        self::STATUS_SEEKING_SPONSORS => 'išče botre',
        self::STATUS_TEMP_NOT_SEEKING_SPONSORS => 'trenutno ne išče botrov',
        self::STATUS_NOT_SEEKING_SPONSORS => 'ne išče botrov',
        self::STATUS_ADOPTED => 'v novem domu',
        self::STATUS_RIP => 'RIP',
    ];

    public const PER_PAGE_12 = 12;
    public const PER_PAGE_24 = 24;
    public const PER_PAGE_ALL = 'all';
    public const PER_PAGE_OPTIONS = [
        self::PER_PAGE_12,
        self::PER_PAGE_24,
        self::PER_PAGE_ALL,
    ];
    public const PER_PAGE_DEFAULT = self::PER_PAGE_12;

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
     * @inheritDoc
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(30);
    }

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

    public function location(): BelongsTo
    {
        return $this->belongsTo(CatLocation::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(CatPhoto::class);
    }

    public function sponsorships(): HasMany
    {
        return $this->hasMany(Sponsorship::class);
    }

    public function sponsorshipMessages(): HasMany
    {
        return $this->hasMany(SponsorshipMessage::class);
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
        static::addGlobalScope('status', function (Builder $builder) {
            $builder->whereNotIn(
                'status',
                [
                    self::STATUS_NOT_SEEKING_SPONSORS,
                    self::STATUS_ADOPTED,
                    self::STATUS_RIP,
                ]
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getGenderLabelAttribute(): string
    {
        return self::GENDER_LABELS[$this->gender];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status];
    }

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
