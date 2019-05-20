<?php

namespace App\Repositories;
use DB;
use App\Models\Band;
use App\Models\User;
use App\Models\Bank_Commerce;

class Bank_CommerceRepository
{
    public function associate ($request){
        return Bank_Commerce::create($request);
    }

    public function disassociate ($commerce_id){
        $bc = Bank_Commerce::where('commerce_id',$commerce_id)->get();
        if (count($bc) > 0)
            return Bank_Commerce::where('commerce_id',$commerce_id)->forceDelete();
        else
            return true;
    }

    public function getBetterRate(){
        $userCommerce = User::with(['commerce','commerce.banks'])->where('id',currentUser()->id)->first();
        $wallets      = User::with(['wallets','wallets.crypto'])->where('id',currentUser()->id)->first();
        $dataWalletRate = [];
        $userWall = $wallets->wallets->toArray();
        $sql = [];

        if( ( !is_null( $wallets ) && count( $userWall ) > 0 ) && !is_null( $userCommerce ) ){

            $arrayBank = $userCommerce->commerce->banks->pluck('id')->toArray();
            $dataWalletRate = ['wallets'=>$userWall];

            if( count( $arrayBank ) > 0 ){
                $sql = DB::table('values_bands')
                    ->join('bands', 'values_bands.band_id', '=', 'bands.id' )
                    ->select(DB::raw('bands.min, bands.max, min(val_cambio) AS price, bands.id AS band_id, min(values_bands.bank_id) AS bank_id'))
                    ->whereIn('values_bands.bank_id',$arrayBank)
                    ->groupBy( 'bands.id')
                    ->orderBy('bands.id')
                    ->get();
            }
            $dataWalletRate['rates'] = $sql;
        }

        return $dataWalletRate;
    }

    /*public function forceBetterRite($sql){
        $bands = Band::all();
        if(count($bands) > 0){
            $j = 0;
            $arr_final = [];

            for($i = 0; $i < count($bands); $i++){
                $existe = false;
                if($sql[$i]->band_id == $bands[$i]->id)
                    $existe = true; break;
                else{

                }
            }
        }
    }*/

    public function getBandToRate( $value ){
        $band = Band::where('min','<=',$value)
                ->where('max','>=',$value)
                ->first();
        return $band;
    }
}