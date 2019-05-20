<?php

namespace App\Repositories;
use App\Models\Bank;

class BankRepository
{
    private $model;

    public function __construct( Bank $bank )
    {
        $this->model = $bank;
    }

    public function indexBank(){
        return Bank::all();
    }

    public function indexBankCommerce($commerce_id){
        return Bank::with(['commerces'=>function($query) use($commerce_id){
            $query->where('commerces.id',$commerce_id)->get();
        }])->get();
    }

    public function storeBank($request)
    {
        return Bank::create($request);
    }

    public function showBank($request)
    {
        $bank = Bank::where('id',$request['id'])->first();

        if( is_null( $bank ) )
            return null;
        else
            return $bank;
    }

    public function updateBank($request)
    {
        $bank = Bank::where('id',$request['id'])->first();

        if( is_null( $bank ) )
            return null;
        else{
            $data = [
                'name'      => $request['name']
            ];
            return Bank::where('id',$request['id'])->update( $data );
        }
    }

    public function destroyBank($bank)
    {
        $bank = Bank::where('id',$bank)->first();

        if( is_null($bank) )
            return null;
        else
            return $bank->delete();
    }
}
