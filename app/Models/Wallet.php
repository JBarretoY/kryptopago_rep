<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property string $name
 * @property string $public_key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wallet onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet wherePublicKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wallet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wallet withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Commerce $commerce
 * @property-read \App\Models\Crypto $crypto
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property int|null $commerce_id
 * @property int|null $crypto_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereCommerceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereCryptoId($value)
 */
class Wallet extends Model
{
    use SoftDeletes;
    protected $table = 'wallets';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'public_key',
        'commerce_id',
        'crypto_id'
    ];

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

    public function crypto(){
        return $this->belongsTo('App\Models\Crypto');
    }

    public function commerce(){
        return $this->belongsTo('App\Models\Commerce');
    }
}
