<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CryptoRepository;

class CryptoController extends Controller
{
    private $crypto;

    public function __construct( CryptoRepository $crypto )
    {
        $this->crypto = $crypto;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json( $this->crypto->indexCrypto() );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resp = $this->crypto->storeCrypto( $request->all() );
        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message'=>'Crypto no encontrada'],404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $resp = $this->crypto->showCrypto( $request->all() );

        if( $resp )
            return response()->json($resp);
        else
            return response()->json(['message'=>'Crypto no encontrada'],404);
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
        $resp = $this->crypto->updateCrypto( $request->all() );
        if( $resp )
            return response()->json($resp);
        else
            return response()->json(['message'=>'Crypto no encontrada'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $resp = $this->crypto->destroyCrypto($request['id']);
        if( $resp )
            return response()->json($resp);
        else
            return response()->json(['message'=>'Crypto no encontrada'],404);
    }
}
