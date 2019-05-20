<?php

namespace App\Repositories;
use App\Models\OrderBook;
use Carbon\Carbon;

class OrderBookRepository
{
    public function tasa(){
        $date = Carbon::now()->subHours('24');
        return OrderBook::whereDate('created_at', '>=', $date)->get();
    }

}
