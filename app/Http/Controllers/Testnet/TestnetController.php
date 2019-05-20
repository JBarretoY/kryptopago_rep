<?php

namespace App\Http\Controllers\Testnet;

use App\Models\User;
use App\Models\Transaction;
//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestnetController extends Controller
{
    const URL_API_TESTNET = 'https://testnet.blockchain.info/';

    public function testnetValidTrans($amount_crypto){

        try{

            if($amount_crypto == 0 || empty($amount_crypto) || is_null($amount_crypto) || !is_numeric($amount_crypto)){
                return response()->json(
                    [
                        'message'=>'error, amount crypto es requerido'
                    ],400);
            }

            $sato = (integer)round( 100000000 * $amount_crypto,0);
            $user_id = currentUser()->id;
            $user = User::with('wallets')->where('id',$user_id)->first();

            if(!empty($user->wallets) || count($user->wallets) > 0){
                $endpoint = self::URL_API_TESTNET . 'rawaddr/' . $user->wallets[0]->public_key . '?limit=1';
                $data = file_get_contents( $endpoint );
                $dataWallet = json_decode($data);

                for($i = 0; $i < count($dataWallet->txs[0]->out); $i++){

                    if( (float)$dataWallet->txs[0]->out[$i]->value == (float)$sato ){
                        $txids = $this->getLastTentTxid($user_id);
                        if( $this->checkTxid($dataWallet->txs[0]->hash,$txids) ){

                            return response()->json([
                                'message' => 'Transaccion verificada',
                                'txid'    => (string)$dataWallet->txs[0]->hash
                            ],200);
                        }
                    }
                }

                return response()->json(
                    [
                        'message'=>"Transaccion no confirmada"
                    ],400);
            }else
                return response()->json(
                    [
                        'message'=>"no wallets"
                    ],400);
        }catch (\Exception $e){
            return response()->json(
                [
                    'message'=>'Ha ocurrido un error, intente luego'
                ],500);
        }
    }

    public function checkTxid($txidNew,$arrayTxid){
        if( count($arrayTxid) == 0 )
            return true;
        else{
            for($i = 0; $i < count($arrayTxid); $i++){
                if($txidNew == $arrayTxid[$i]->txid)
                    return false;
            }
            return true;
        }
    }

    public function getLastTentTxid($user_id){
        return Transaction::whereUserId($user_id)->orderBy('created_at','desc')->take(10)->get();
    }
}