<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Value_Band
 *
 * @property int $id
 * @property float $val_cambio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $bank_id
 * @property int|null $band_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Value_Band onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band whereBandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band whereValCambio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Value_Band withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Value_Band withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Band|null $band
 * @property-read \App\Models\Bank|null $bank
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Value_Band query()
 */
class Value_Band extends Model
{
    use SoftDeletes;
    protected $table = 'values_bands';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'val_cambio','bank_id','band_id',
    ];

    public function band(){
        return $this->belongsTo('App\Models\Band');
    }

    public function bank(){
        return $this->belongsTo('App\Models\Bank');
    }
}
