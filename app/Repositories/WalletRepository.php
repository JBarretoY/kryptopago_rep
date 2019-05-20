<?php

namespace App\Repositories;
use App\Models\Wallet;
use App\Models\User;

class WalletRepository
{
    public function indexWallet(){
        return Wallet::with('users')->orderBy('id', 'desc')->paginate(10);
        //return Commerce::with('wallets')->orderBy('id', 'desc')->paginate(10);
    }

    public function indexWalletCommerce($commerce_id){
        return Wallet::with('users')->where('commerce_id',$commerce_id)->orderBy('id', 'desc')->paginate(10);
    }

    public function storeWallet($request)
    {
        return Wallet::create($request);
    }

    public function showWallet($request)
    {
        $wallet = Wallet::where('id',$request['id'])->first();

        if( is_null( $wallet ) )
            return null;
        else
            return $wallet;  
    }

    public function updateWallet($request)
    {
        $wallet = Wallet::where('id',$request['id'])->first();

        if( is_null( $wallet ) )
            return null;
        else{
            $data = [
                'name'      => $request['name'],
                'public_key'=> $request['public_key']
            ];
            $up = $wallet->update($data);
            
            if($up)
                return $wallet->refresh();
            else
                return $up;
        }
    }

    public function destroyWallet($id)
    {
        $wallet = Wallet::where('id',$id)->first();

        if( is_null($wallet) )
            return null;
        else
            return $wallet->delete();
    }

    public function userWallet ($wallet){
        $query = User::with('wallets')->where('id',$wallet)->paginate(10);
        return $query[0]->wallets;
    }

    public function getWalletNoUser($id){
        return !is_null($id) ?
            Wallet::doesntHave('users')->with('commerce')->where('commerce_id', $id)->paginate(10) : 401;
    }
}
