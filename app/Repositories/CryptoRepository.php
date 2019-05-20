<?php

namespace App\Repositories;
use App\Models\Crypto;

class CryptoRepository
{
    public function indexCrypto(){
        return Crypto::all();
    }

    public function storeCrypto($request)
    {
        return Crypto::create($request);
    }

    public function showCrypto($request)
    {
        $crypto = Crypto::where('id',$request['id'])->first();

        if( is_null( $crypto ) )
            return null;
        else
            return $crypto;
    }

    public function updateCrypto($request)
    {
        $crypto = Crypto::where('id',$request['id'])->first();

        if( is_null( $crypto ) )
            return null;
        else{
            $data = [
                'name'  => $request['name']
            ];
            return Crypto::where('id',$request['id'])->update( $data );
        }
    }

    public function destroyCrypto($crypto)
    {
        $crypto = Crypto::where('id',$crypto)->first();

        if( is_null($crypto) )
            return null;
        else
            return $crypto->delete();
    }
}
