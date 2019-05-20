<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Band
 *
 * @property int $id
 * @property float $min
 * @property float $max
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Band onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Band whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Band whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Band whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Band whereMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Band whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Band whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Band withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Band withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Value_Band[] $value_band
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Band newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Band newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Band query()
 */
class Band extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'bands';
    protected $fillable = [
        'min', 'max',
    ];

    public function value_band(){
        return $this->hasMany('App\Models\Value_Band');
    }
}
