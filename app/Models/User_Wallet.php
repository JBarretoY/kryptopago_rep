<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\User_Wallet
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $wallet_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_Wallet onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User_Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User_Wallet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User_Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User_Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User_Wallet whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User_Wallet whereWalletId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_Wallet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User_Wallet withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User_Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User_Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User_Wallet query()
 */
class User_Wallet extends Model
{
    use SoftDeletes;
    protected $table = 'user_wallet';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id','wallet_id',
    ];
}
