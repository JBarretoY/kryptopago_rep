<?php

namespace App\Http\Controllers;

use App\Repositories\AvgRepository;
use App\Repositories\Value_BandRepository;
use App\Repositories\OrderBookRepository;
use App\Repositories\CommerceRepository;
use App\Repositories\TransactionRepository;

class AvgController extends Controller
{
	private $avg;
    private $orderbook;
    private $commerce;
    private $trans;

    public function __construct( AvgRepository $avg, Value_BandRepository $value_band, OrderBookRepository $orderbook, CommerceRepository $commerce, TransactionRepository $trans)
    {
        $this->avg        = $avg;
        $this->value_band = $value_band;
        $this->orderbook  = $orderbook;
        $this->commerce   = $commerce;
        $this->trans      = $trans;
    }

    public function lastAvg(){
        $cant = [];
        $date = [];
        $user = currentUser();

        if ($user->type === 1){
            $avg      = $this->avg->lastAvg();
            $order    = $this->orderbook->tasa();
            $avg24    = $this->avg->Avg24();

            $alto     = $order->max('max_bid');
            $bajo     = $order->min('min_bid');
            $oferta   = $order->avg('avg_bid');
            $demand   = $order->avg('avg_ask');
            $vol      = $avg->volume_btc;
            
            if (count($avg24) > 0)
                $cambio   = (($avg24->last()->avg_24h - $avg24->first()->avg_24h) / $avg24->first()->avg_24h) * 100;
            else
                $cambio   = 0;

            if (count($avg24) > 0){
                $cambio   = (($avg24->last()->avg_24h - $avg24->first()->avg_24h) / $avg24->first()->avg_24h) * 100;
                $vol      = $avg->volume_btc;
                for ($i=0; $i < count($avg24); $i++) { 
                    $cant[] = $avg24[$i]->avg_24h;
                    $date1  = explode(' ',$avg24[$i]->created_at);
                    $date[] = $date1[1]; 
                }
            }

            $valor       = 0;
            $cantidad    = 0;
            $h24         = 0;
            $tasa_commer = 0;

            return response()->json(['avg' => $avg,'alto' => $alto,'bajo' => $bajo,'oferta' => $oferta, 'demanda' =>
            $demand, 'volume' => $vol, 'cambio' => $cambio, 'valor' => $valor, 'cantidad' => $cantidad, 'h24' => $h24, 'cant_graf' => $cant, 'date_graf' => $date, 'tasa' => $tasa_commer] ,200 );
        }else{
            $avg      = $this->avg->lastAvg();
            $order    = $this->orderbook->tasa();
            $avg24    = $this->avg->Avg24();
            $commerce = $this->commerce->showCommerce($user->commerce_id);
            $trans    = $this->trans->indexTransCommerce($user->commerce_id);
            
            $alto     = $order->max('max_bid');
            $bajo     = $order->min('min_bid');
            $oferta   = $order->avg('avg_bid');
            $demand   = $order->avg('avg_ask');

            $cambio      = 0;
            $vol         = 0;
            $h24         = 0;
            $tasa_commer = 0;
            
            if (count($avg24) > 0){
                $cambio   = (($avg24->last()->avg_24h - $avg24->first()->avg_24h) / $avg24->first()->avg_24h) * 100;
                $vol      = $avg->volume_btc;

                for ($i=0; $i < count($avg24); $i++) { 
                    $cant[] = $avg24[$i]->avg_24h;
                    $date1  = explode(' ',$avg24[$i]->created_at);
                    $date[] = $date1[1]; 
                }

                if(count($trans) > 0){
                    $tasa_commer = $commerce->total_VES_by_BTC / $commerce->total_BTC;

                    $h24  = (($avg24->last()->avg_24h - $tasa_commer) / $tasa_commer) * 100;
                }
            }

            $valor        = $commerce->total_VES_by_BTC;
            $cantidad     = $commerce->total_BTC;

            

            return response()->json(['avg' => $avg,'alto' => $alto,'bajo' => $bajo,'oferta' => $oferta, 'demanda' =>
                $demand, 'volume' => $vol, 'cambio' => $cambio, 'valor' => $valor, 'cantidad' => $cantidad, 'h24' => $h24, 'cant_graf' => $cant, 'date_graf' => $date, 'tasa' => $tasa_commer] ,200 );
        }
    }

    public function avgWeek(){
        $avg = $this->avg->avgWeek();
        for ($i=0; $i < count($avg); $i++) { 
            $graf[] = $avg[$i]->avg_24h;
            $date[] = $avg[$i]->created_at;
        }
        return response()->json(['cant_graf' => $graf, 'date_graf' => $date],200);
    }
}
