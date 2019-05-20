<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Cron
 *
 * @property int $id
 * @property string $bank_name
 * @property float $temp_price
 * @property float $min_amount
 * @property float $max_amount
 * @property mixed $json
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cron onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereMaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereMinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereTempPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cron withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cron withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cron query()
 */
class Cron extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'bank_name','temp_price','min_amount','max_amount','json',
    ];
    protected $table = 'crons';
}
