<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Commerce
 *
 * @property int $id
 * @property string $name
 * @property string $rif
 * @property string $phone
 * @property string $email
 * @property string $addres
 * @property string $city
 * @property string $state
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Commerce onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereAddres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereRif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Commerce withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Commerce withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bank[] $banks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wallet[] $wallets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce query()
 * @property float $total_VES_by_BTC
 * @property float $total_BTC
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereTotalBTC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Commerce whereTotalVESByBTC($value)
 */
class Commerce extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'rif',
        'phone',
        'email',
        'addres',
        'city',
        'state',
        'type',
        'total_VES_by_BTC',
        'total_BTC'
    ];
    protected $table = 'commerces';

    public function users(){
        return $this->hasMany('App\Models\User');
    }

    public function wallets(){
        return $this->hasMany('App\Models\Wallet');
    }

    public function transactions(){
        return $this->hasMany('App\Models\Transaction');
    }

    public function banks(){
        return $this->belongsToMany('App\Models\Bank');
    }
}
