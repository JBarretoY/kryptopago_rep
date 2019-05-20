<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BandRepository;
use App\Models\Band;

class BandController extends Controller
{
    private $band;

    public function __construct( BandRepository $band )
    {
        $this->band = $band;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resp = $this->band->indexBand();

        if( $resp )
            return response()->json($resp,201);
        else
            return response()->json('error',500);
    }

    public function store(Request $request)
    {
        $resp = $this->band->storeBand( $request->all() );
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
        $resp = $this->band->showBand( $request->all() );

        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message'=>'Banda no encontrada'],404);
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
        $resp = $this->band->updateBand( $request->all() );
        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message'=>'Banda no encontrada'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $resp = $this->band->destroyBand($request['id']);
        if( $resp )
            return response()->json($resp);
        else
            return response()->json(['message'=>'Banda no encontrada'],404);
    }
}
