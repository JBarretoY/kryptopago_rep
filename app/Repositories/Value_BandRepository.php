<?php

namespace App\Repositories;
use App\Models\Value_Band;
use Carbon\Carbon;

class Value_BandRepository
{
    public function getLimits (){
        $value = Value_Band::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->get();
        return $value;
    }
}
