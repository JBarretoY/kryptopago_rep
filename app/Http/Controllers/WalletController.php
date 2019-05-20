<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use Illuminate\Http\Request;
use App\Repositories\WalletRepository;
use App\Repositories\UserRepository;
use Ixudra\Curl\Facades\Curl;


class WalletController extends Controller
{
    private $wallet;

    public function __construct( WalletRepository $wallet, UserRepository $user)
    {
        $this->wallet      = $wallet;
        $this->user        = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = currentUser();

        if ($user->type === 1)
            $wallet = $this->wallet->indexWallet();
        elseif ($user->type === 2) {
            $wallet = $this->wallet->indexWalletCommerce($user->commerce_id);
        }else
            $wallet = $this->wallet->userWallet($user->id); 

        if($wallet)
            return response()->json( ['wallets' => $wallet],200 );
        else
            return response()->json( ['message' => 'No data'],400 );
    }
    public static function validateAddress($addres,$currency,$testnet=0){
        $valid = Curl::to(env('VALID_ADDRESS_SERVICE') . $addres . '/'. $currency .'/'. $testnet )->get();
        $resp  = json_decode($valid);
        return isset($resp->message) && $resp->message == 'Direccion Valida';
    }
    /*public function index()
    {
        $user = currentUser();

        if ($user->type === 1){
            $wallet = $this->wallet->indexWallet();
            if($wallet)
                return response()->json( ['commerce' => $wallet],200 );
            else
                return response()->json( ['message' => 'No data'],400 );
        }
        elseif ($user->type === 2) 
            $wallet = $this->wallet->indexWalletCommerce($user->commerce_id);
        else
            $wallet = $this->wallet->userWallet($user->id); 

        if($wallet)
            return response()->json( ['wallets' => $wallet],200 );
        else
            return response()->json( ['message' => 'No data'],400 );
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user   = currentUser();
        $crypto = Crypto::where('id',$request->input('crypto_id'))->first();

        if( self::validateAddress($request->input('public_key'),$crypto->name,0) ){
            $data = [
                      'name'        => $request->input('name'),
                      'public_key'  => $request->input('public_key'),
                      'commerce_id' => $user->commerce_id,
                      'crypto_id'   => $request->input('crypto_id')
                ];

            $resp = $this->wallet->storeWallet( $data );
            if( $resp )
                return response()->json($resp,201);
            else
                return response()->json('error',500);
        }else{
            return response()->json(['message'=>'Direccion Invalida'],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $resp = $this->wallet->showWallet( $request->all() );

        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message'=>'Wallet no encontrada'],404);
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
        $resp = $this->wallet->updateWallet( $request->all() );
        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message'=>'Wallet no encontrada'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resp = $this->wallet->destroyWallet($id);
        if( $resp )
            return response()->json($resp);
        else
            return response()->json(['message'=>'Wallet no encontrada'],404);
    }

    public function walletNoUser(){
        $user = currentUser()->commerce_id;
        $resp = $this->wallet->getWalletNoUser($user);
       
        if( gettype($resp) == 'object' )
            return response()->json( ['wallet' => $resp] ,200 );
        else
            return response()->json(['message' => 'No autorizado'],401);
    }
}
