<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Bank_Commerce
 *
 * @property int $id
 * @property int|null $bank_id
 * @property int|null $commerce_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bank_Commerce onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank_Commerce whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank_Commerce whereCommerceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank_Commerce whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank_Commerce whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank_Commerce whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank_Commerce whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bank_Commerce withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bank_Commerce withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank_Commerce newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank_Commerce newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank_Commerce query()
 */
class Bank_Commerce extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'bank_id','commerce_id',
    ];
    protected $table = 'bank_commerce';
}
