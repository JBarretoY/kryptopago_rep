<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $date
 * @property float $amount_bs
 * @property float $amount_crypto
 * @property int $reference
 * @property float $btc_value
 * @property string $txid
 * @property bool $validate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $commerce_id
 * @property int|null $user_id
 * @property int|null $crypto_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transaction onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereAmountBs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereAmountCrypto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereBtcValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCommerceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCryptoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereTxid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereValidate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transaction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transaction withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Commerce|null $commerce
 * @property-read \App\User|null $user
 * @property-read \App\Models\Wallet $wallet
 * @property int|null $wallet_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereWalletId($value)
 * @property int|null $bank_id
 * @property int|null $band_id
 * @property-read \App\Models\Bank|null $bank
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereBandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereBankId($value)
 */
class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
        'date',
        'amount_bs',
        'amount_crypto',
        'reference',
        'btc_value',
        'txid',
        'validate',
        'commerce_id',
        'user_id',
        'wallet_id',
        'bank_id',
        'band_id'
    ];

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function commerce(){
        return $this->belongsTo('App\Models\Commerce');
    }

    public function wallet(){
        return $this->belongsTo('App\Models\Wallet');
    }

    public function bank(){
        return $this->belongsTo('App\Models\Bank');
    }
}
