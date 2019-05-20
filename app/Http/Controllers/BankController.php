<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BankRepository;

class BankController extends Controller
{
    private $bank;

    public function __construct( BankRepository $bank )
    {
        $this->bank = $bank;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = currentUser();
        if ($user->type == 1){
            $resp = $this->bank->indexBank();
            if ($resp)
                return response()->json( ['banks' => $resp],200 );
            else
                return response()->json( ['message' => 'No data'],400 );
        }
        elseif ($user->type === 2){
            $resp = $this->bank->indexBankCommerce($user->commerce_id);
            if ($resp)
                return response()->json( ['banks' => $resp],200 );
            else
                return response()->json( ['message' => 'No data'],400 );
        }
        else
            return response()->json( ['message' => 'Usuario no autorizado'],400 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resp = $this->bank->storeBank( $request->all() );
        if( $resp )
            return response()->json($resp,201);
        else
            return response()->json('error',500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $resp = $this->bank->showBank( $request->all() );

        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message' => 'Banco no encontrado'],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $resp = $this->bank->updateBank( $request->all() );
        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message' => 'Banco no encontrado'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $resp = $this->bank->destroyBank($id);
        if( $resp )
            return response()->json($resp);
        else
            return response()->json(['message' => 'Banco no encontrado'],404);
    }
}
