<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Crypto
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crypto onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crypto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crypto whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crypto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crypto whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crypto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crypto withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crypto withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wallet[] $wallets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crypto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crypto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Crypto query()
 */
class Crypto extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
    ];
    protected $table = 'cryptos';

    public function wallets(){
        return $this->hasMany('App\Models\Wallet');
    }

   /*public function transactions(){
        return $this->hasMany('App\Models\Transaction');
    }*/
}
