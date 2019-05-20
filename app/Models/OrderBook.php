<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * App\Models\OrderBook
 *
 * @property int $id
 * @property float $min_bid
 * @property float $max_bid
 * @property float $avg_bid
 * @property float $min_ask
 * @property float $max_ask
 * @property float $avg_ask
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBook onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereAvgAsk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereAvgBid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereMaxAsk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereMaxBid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereMinAsk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereMinBid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderBook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBook withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBook withoutTrashed()
 * @mixin \Eloquent
 */
class OrderBook extends Model
{
    use SoftDeletes;

    protected $table = 'order_books';
    protected $fillable = [
        'min_bid',
        'max_bid',
        'avg_bid',
        'min_ask',
        'max_ask',
        'avg_ask'
    ];
    protected $dates = ['deleted_at'];
}
