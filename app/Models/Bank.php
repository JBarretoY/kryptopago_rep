<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Bank
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bank onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bank withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Bank withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Commerce[] $commerces
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Value_Band[] $value_band
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bank query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 */
class Bank extends Model
{

    use SoftDeletes;
    protected $table = 'banks';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];

    public function commerces(){
        return $this->belongsToMany('App\Models\Commerce');
    }

    public function value_band(){
        return $this->hasMany('App\Models\Value_Band');
    }

    public function transactions(){
        return $this->hasMany('App\Models\Transaction');
    }
}
