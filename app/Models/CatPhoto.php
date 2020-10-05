<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CatPhoto
 *
 * @property int $id
 * @property string $path
 * @property string|null $alt
 * @property int $cat_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Cat $cat
 * @method static Builder|CatPhoto newModelQuery()
 * @method static Builder|CatPhoto newQuery()
 * @method static Builder|CatPhoto query()
 * @method static Builder|CatPhoto whereAlt($value)
 * @method static Builder|CatPhoto whereCatId($value)
 * @method static Builder|CatPhoto whereCreatedAt($value)
 * @method static Builder|CatPhoto whereId($value)
 * @method static Builder|CatPhoto wherePath($value)
 * @method static Builder|CatPhoto whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CatPhoto extends Model
{
    use HasFactory;

    /**
     * Get the cat this photo belongs to.
     *
     * @return BelongsTo
     */
    public function cat()
    {
        return $this->belongsTo(Cat::class);
    }
}
