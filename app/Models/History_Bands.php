<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\History_Bands
 *
 * @property int $id
 * @property float $min_value_init
 * @property float $max_value_init
 * @property float $min_value_half
 * @property float $max_value_half
 * @property float $min_value_end
 * @property float $max_value_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\History_Bands onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereMaxValueEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereMaxValueHalf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereMaxValueInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereMinValueEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereMinValueHalf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereMinValueInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\History_Bands whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\History_Bands withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\History_Bands withoutTrashed()
 * @mixin \Eloquent
 */
class History_Bands extends Model
{
    use SoftDeletes;
    protected $table = 'history_bands';
    protected $dates = ['deleted_at'];
    protected $fillable = ['min_value_init',
                           'max_value_init',
                           'min_value_half',
                           'max_value_half',
                           'min_value_end',
                           'max_value_end'];
}
