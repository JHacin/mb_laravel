<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\SponsorshipMessageType
 *
 * @property int $id
 * @property string $name
 * @property string $template_id
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|SponsorshipMessage[] $sponsorshipMessages
 * @property-read int|null $sponsorship_messages_count
 * @method static Builder|SponsorshipMessageType newModelQuery()
 * @method static Builder|SponsorshipMessageType newQuery()
 * @method static Builder|SponsorshipMessageType query()
 * @method static Builder|SponsorshipMessageType whereCreatedAt($value)
 * @method static Builder|SponsorshipMessageType whereId($value)
 * @method static Builder|SponsorshipMessageType whereIsActive($value)
 * @method static Builder|SponsorshipMessageType whereName($value)
 * @method static Builder|SponsorshipMessageType whereTemplateId($value)
 * @method static Builder|SponsorshipMessageType whereUpdatedAt($value)
 * @mixin Eloquent
 */
class SponsorshipMessageType extends Model
{
    use CrudTrait, HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sponsorship_message_types';
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
