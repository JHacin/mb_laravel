<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\PersonData
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $email
 * @property int $gender
 * @property string|null $first_name
 * @property string|null $last_name
 * @property Carbon|null $date_of_birth
 * @property string|null $address
 * @property string|null $zip_code
 * @property string|null $city
 * @property string|null $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $email_and_user_id
 * @property-read string $gender_label
 * @property-read Collection|SponsorshipMessage[] $sponsorshipMessages
 * @property-read int|null $sponsorship_messages_count
 * @property-read Collection|Sponsorship[] $sponsorships
 * @property-read int|null $sponsorships_count
 * @property-read Collection|Sponsorship[] $unscopedSponsorships
 * @property-read int|null $unscoped_sponsorships_count
 * @property-read User|null $user
 * @method static Builder|PersonData newModelQuery()
 * @method static Builder|PersonData newQuery()
 * @method static Builder|PersonData query()
 * @method static Builder|PersonData whereAddress($value)
 * @method static Builder|PersonData whereCity($value)
 * @method static Builder|PersonData whereCountry($value)
 * @method static Builder|PersonData whereCreatedAt($value)
 * @method static Builder|PersonData whereDateOfBirth($value)
 * @method static Builder|PersonData whereEmail($value)
 * @method static Builder|PersonData whereFirstName($value)
 * @method static Builder|PersonData whereGender($value)
 * @method static Builder|PersonData whereId($value)
 * @method static Builder|PersonData whereLastName($value)
 * @method static Builder|PersonData whereUpdatedAt($value)
 * @method static Builder|PersonData whereUserId($value)
 * @method static Builder|PersonData whereZipCode($value)
 * @mixin Eloquent
 */
class PersonData extends Model
{
    use HasFactory, CrudTrait;

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
        self::GENDER_MALE => 'Moški',
        self::GENDER_FEMALE => 'Ženska',
    ];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'person_data';
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * Todo: user_id?
     */
    protected $fillable = [
        'email',
        'gender',
        'first_name',
        'last_name',
        'date_of_birth',
        'address',
        'zip_code',
        'city',
        'country',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Used in Backpack when showing the model instance label via relationship inputs.
     *
     * @var string
     */
    protected $identifiableAttribute = 'email_and_user_id';

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function unscopedSponsorships(): HasMany
    {
        return $this->sponsorships()->withoutGlobalScopes();
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

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Convert the stored integer to a label shown on the front end.
     *
     * @return string
     */
    public function getGenderLabelAttribute(): string
    {
        return self::GENDER_LABELS[$this->gender];
    }

    /**
     * Returns the email followed by the user ID (or the "not registered" label) enclosed in parentheses.
     *
     * @return string
     */
    public function getEmailAndUserIdAttribute(): string
    {
        return sprintf('%s (%s)', $this->email, $this->user_id ?? 'ni registriran');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
