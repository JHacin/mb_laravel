<?php

namespace App\Models;

use App\Services\CatPhotoService;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Storage;

/**
 * App\Models\CatPhoto
 *
 * @property int $id
 * @property string|null $alt
 * @property int $cat_id
 * @property string $filename
 * @property int $index
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Cat $cat
 * @property-read string $url
 * @method static Builder|CatPhoto newModelQuery()
 * @method static Builder|CatPhoto newQuery()
 * @method static Builder|CatPhoto query()
 * @method static Builder|CatPhoto whereAlt($value)
 * @method static Builder|CatPhoto whereCatId($value)
 * @method static Builder|CatPhoto whereCreatedAt($value)
 * @method static Builder|CatPhoto whereId($value)
 * @method static Builder|CatPhoto whereUpdatedAt($value)
 * @method static Builder|CatPhoto whereIndex($value)
 * @method static Builder|CatPhoto whereFilename($value)
 * @mixin Eloquent
 */
class CatPhoto extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'cat_photos';
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
     * Get the cat this photo belongs to.
     *
     * @return BelongsTo
     */
    public function cat()
    {
        return $this->belongsTo(Cat::class);
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
     * Returns the full URL for this photo.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::url(CatPhotoService::getFullPath($this->filename));
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
