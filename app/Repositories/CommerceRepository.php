<?php

namespace App\Repositories;
use App\Models\Commerce;

class CommerceRepository
{
    public function indexCommerce(){
        return Commerce::all();
    }

    public function storeCommerce($request)
    {
        return Commerce::create($request);
    }

    public function showCommerce($id)
    {
       $commerce = Commerce::where('id',$id)->first();

        if( is_null( $commerce ) )
            return null;
        else
            return $commerce;
    }

    public function updateCommerce($request)
    {
        $commerce = Commerce::where('id',$request['id'])->first();

        if( is_null( $commerce ) )
            return null;
        else{
            $data = [
                'name'      => $request['name'],
                'rif'       => $request['rif'],
                'phone'     => $request['phone'],
                'email'     => $request['email'],
                'addres'    => $request['addres'],
                'city'      => $request['city'],
                'state'     => $request['state'],
                'type'      => $request['type']
            ];
            $up = $commerce->update( $data );
            if ($up)
                return $commerce->refresh();
            else
                return $up;
        }
    }

    public function destroyCommerce($commerce)
    {
        $commerce = Commerce::where('id',$commerce)->first();

        if( is_null($commerce) )
            return null;
        else
            return $commerce->delete();

    }

    public function updateTotals($data){
        $commerce = Commerce::where('id',$data['id'])->first();
        
        $commerce->total_VES_by_BTC = $commerce['total_VES_by_BTC'] + $data['VES'];
        $commerce->total_BTC = $commerce['total_BTC'] + $data['BTC'];
        return $commerce->save();
    }
}
