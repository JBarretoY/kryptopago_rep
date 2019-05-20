<?php

namespace App\Repositories;
use App\Models\User_Wallet;

class User_WalletRepository
{
    public function associate ($request){
        return User_Wallet::create($request);
    }

    public function disassociate ($request){
        return User_Wallet::where('wallet_id',$request['wallet_id'])->where('user_id',$request['user_id'])->forceDelete();
    }

    public function associateExist ($wallet_id){
    	$exis = User_Wallet::where('wallet_id',$wallet_id)->first();
    	if (is_null($exis))
    		return null;
    	else
    		return $exis;
    }

    public function getAssociate ($user_id){
        return User_Wallet::where('user_id',$user_id)->get();
    }
}
