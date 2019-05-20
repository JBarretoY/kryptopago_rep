<?php

namespace App\Repositories;
use App\Models\Avg;
use Carbon\Carbon;

class AvgRepository
{
    public function lastAvg(){
    	$avg = Avg::where('currency','VES')->get();
        return $avg->last();
    }

    public function Avg24(){
    	$date = Carbon::now()->subHours('24');
    	return Avg::whereDate('created_at', '>=', $date)->where('currency','VES')->get();
    }

    public function avgWeek(){
    	$date = Carbon::now()->subWeek();
    	return Avg::whereDate('created_at', '>=', $date)->where('currency','VES')->get();
    }

}
