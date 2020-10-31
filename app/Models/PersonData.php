<?php

namespace App\Models;

use App\Helpers\SharedAttributes;
use App\Rules\CountryCode;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;


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
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $zip_code
 * @property string|null $city
 * @property string|null $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $email_and_user_id
 * @property-read string $gender_label
 * @property-read Collection|Sponsorship[] $sponsorships
 * @property-read int|null $sponsorships_count
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
 * @method static Builder|PersonData wherePhone($value)
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
    public const TABLE_NAME = 'person_data';

    public const ATTR__USER_ID = 'user_id';
    public const ATTR__EMAIL_AND_USER_ID = 'email_and_user_id';
    public const ATTR__FIRST_NAME = 'first_name';
    public const ATTR__LAST_NAME = 'last_name';
    public const ATTR__PHONE = 'phone';
    public const ATTR__GENDER = SharedAttributes::GENDER;
    public const ATTR__DATE_OF_BIRTH = SharedAttributes::DATE_OF_BIRTH;
    public const ATTR__ADDRESS = SharedAttributes::ADDRESS;
    public const ATTR__ZIP_CODE = SharedAttributes::ZIP_CODE;
    public const ATTR__CITY = SharedAttributes::CITY;
    public const ATTR__COUNTRY = SharedAttributes::COUNTRY;
    public const ATTR__EMAIL = SharedAttributes::EMAIL;

    public const GENDER_UNKNOWN = 0;
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    public const GENDERS = [
        self::GENDER_UNKNOWN,
        self::GENDER_MALE,
        self::GENDER_FEMALE,
    ];

    public const GENDER_LABELS = [
        self::GENDER_UNKNOWN => 'Neznano',
        self::GENDER_MALE => 'Moški',
        self::GENDER_FEMALE => 'Ženska',
    ];

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = self::TABLE_NAME;
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * Todo: user_id?
     */
    protected $fillable = [
        self::ATTR__EMAIL,
        self::ATTR__GENDER,
        self::ATTR__FIRST_NAME,
        self::ATTR__LAST_NAME,
        self::ATTR__DATE_OF_BIRTH,
        self::ATTR__PHONE,
        self::ATTR__ADDRESS,
        self::ATTR__ZIP_CODE,
        self::ATTR__CITY,
        self::ATTR__COUNTRY,
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
    protected $identifiableAttribute = self::ATTR__EMAIL_AND_USER_ID;

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return array
     */
    public static function getSharedValidationRules()
    {
        return [
            self::ATTR__FIRST_NAME => ['nullable', 'string', 'max:255'],
            self::ATTR__LAST_NAME => ['nullable', 'string', 'max:255'],
            self::ATTR__GENDER => [Rule::in(PersonData::GENDERS)],
            self::ATTR__PHONE => ['nullable', 'string', 'max:255'],
            self::ATTR__DATE_OF_BIRTH => ['nullable', 'date', 'before:now'],
            self::ATTR__ADDRESS => ['nullable', 'string', 'max:255'],
            self::ATTR__ZIP_CODE => ['nullable', 'string', 'max:255'],
            self::ATTR__CITY => ['nullable', 'string', 'max:255'],
            self::ATTR__COUNTRY => ['nullable', new CountryCode],
        ];
    }

    /**
     * @return string[]
     */
    public static function getSharedValidationMessages()
    {
        return [
            self::ATTR__DATE_OF_BIRTH . '.before' => 'Datum rojstva mora biti v preteklosti.',
        ];
    }

    /**
     * @return bool
     */
    public function belongsToRegisteredUser()
    {
        return $this->user()->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user that owns this data.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sponsorships that include this user.
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
     * Convert the stored integer to a label shown on the front end.
     *
     * @return string
     */
    public function getGenderLabelAttribute()
    {
        return self::GENDER_LABELS[$this->gender];
    }

    /**
     * Returns the email followed by the user ID (or the "not registered" label) enclosed in parentheses.
     *
     * @return string
     */
    public function getEmailAndUserIdAttribute()
    {
        return sprintf('%s (%s)', $this->email, $this->user_id ?? 'ni registriran');
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
