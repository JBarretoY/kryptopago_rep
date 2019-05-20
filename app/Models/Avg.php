<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Avg
 *
 * @property int $id
 * @property float|null $avg_12h
 * @property float|null $volume_btc
 * @property float|null $avg_24h
 * @property float|null $avg_1h
 * @property float|null $avg_6h
 * @property float|null $last
 * @property mixed $json
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Avg onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereAvg12h($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereAvg1h($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereAvg24h($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereAvg6h($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereLast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereVolumeBtc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Avg withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Avg withoutTrashed()
 * @mixin \Eloquent
 * @property string $currency
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Avg whereDeletedAt($value)
 */
class Avg extends Model
{
    use SoftDeletes;

    protected $fillable = ['avg_12h','volume_btc','avg_24h','avg_1h','avg_6h','last','json','currency'];
    protected $table = 'avgs';
    protected $dates = ['deleted_at'];
}
