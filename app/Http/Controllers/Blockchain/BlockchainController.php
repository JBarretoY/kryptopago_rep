<?php

namespace App\Http\Controllers\Blockchain;

use App\Models\User;
use Blockchain\Blockchain;
use App\Models\Transaction;
//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlockchainController extends Controller
{
    public function validateTransaction($amount_crypto){
        try{

            if($amount_crypto == 0 || empty($amount_crypto) || is_null($amount_crypto) || !is_numeric($amount_crypto)){
                return response()->json( ['message'=>'error, amount crypto es requerido'],100 );
            }

            $user_id = currentUser()->id;
            $user = User::with('wallets')->where('id',$user_id)->first();

            if(isset($user->wallets[0]->public_key))
                $addresWallet = $user->wallets[0]->public_key;
            else
                return response()->json('Usuario sin Wallet',400);

            if( !empty($user->wallets) || count($user->wallets) > 0 ){

                $block = new Blockchain( env('API_CODE_BLOCKCHAIN') );
                $block->setTimeout(100);
                $dataWallet = $block->Explorer->getAddress($addresWallet,100);

                $totalTrans = count($dataWallet->transactions);

                if( $totalTrans > 0 ){
                    for( $x = 0, $y = $totalTrans; $x < $y; $x++ ){
                        for( $i = 0, $j = count($dataWallet->transactions[$x]->outputs); $i < $j; $i++ ){
                            if( $dataWallet->transactions[$x]->outputs[$i]->value == $amount_crypto ) {
                                $txids = $this->getLastTentTxid($user_id);
                                if ($this->checkTxid($dataWallet->transactions[$x]->hash, $txids)) {

                                    return response()->json(
                                        [
                                            'message' => 'Transaccion verificada',
                                            'txid' => (string)$dataWallet->transactions[0]->hash
                                        ], 200);
                                }
                            }
                        }
                    }
                }else
                    return response()->json(['message'=>'sin transacciones'],400);


                return response()->json(
                    [
                        'message'=>'Transaccion aun no verificada'
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

    public function getInfWallet($wallet=null){
        $block = new Blockchain();
        $dataWallet = $block->Explorer->getAddress($wallet,1);
        dd($dataWallet);
    }
}
