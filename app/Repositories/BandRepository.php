<?php

namespace App\Repositories;
use App\Models\Band;

class BandRepository
{
    public function indexBand(){
        return Band::all();
    }

    public function storeBand($request)
    {
        return Band::create($request);
    }

    public function showBand($request)
    {
        $band = Band::where('id',$request['id'])->first();

        if( is_null( $band ) )
            return null;
        else
            return $band;
    }

    public function updateBand($request)
    {
        $band = Band::where('id',$request['id'])->first();

        if( is_null( $band ) )
            return null;
        else{
            $data = [
                'min'      => $request['min'],
                'max'       => $request['max']
            ];
            return Band::where('id',$request['id'])->update( $data );
        }
    }

    public function destroyBand($band)
    {
        $band = Band::where('id',$band)->first();

        if( is_null($band) )
            return null;
        else
            return $band->delete();
    }
}
