<?php

namespace App\Http\Controllers\Cron;
use DB;
use Carbon\Carbon;
use App\Models\Avg;
use App\Models\Cron;
use App\Models\Band;
use App\Models\OrderBook;
use App\Models\Value_Band;
use App\Models\History_Bands;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicMarketDataSell;

class CronApp extends Controller
{
    private $ctrlSellAds;
    private $carbon;

    public function __construct()
    {
        $this->ctrlSellAds = new PublicMarketDataSell();
        $this->carbon = Carbon::now( new \DateTimeZone('America/Caracas') );

    }

    public function updateAds(){
        ini_set('max_execution_time', 900);
        try{
            DB::beginTransaction();
            $updateAds = $this->ctrlSellAds->getAdsAll();
            $countAds  = count( $updateAds );

            if ( $countAds > 0 ){

                Cron::truncate();

                for( $i = 0,$j = $countAds; $i < $j; $i++ ){

                    if($this->checkRangePrice($updateAds[$i]->temp_price)){
                        $array = [
                            'bank_name'  => $updateAds[$i]->bank_name,
                            'temp_price' => $updateAds[$i]->temp_price,
                            'min_amount' => $updateAds[$i]->min_amount == null ? 0 : $updateAds[$i]->min_amount,
                            'max_amount' => $updateAds[$i]->max_amount == null ? 0 : $updateAds[$i]->max_amount,
                            'json'       => json_encode( $updateAds[$i] )
                        ];
                        Cron::create( $array );
                    }
                }

            }
        }catch ( \Exception $e ){
            DB::rollBack();
            \Log::error("Error! - Cron update ads ".$e->getMessage() ." - At ".$this->carbon );
        }
        DB::commit();
        //\Log::info("Finish - Successfully! / Cron update ads - At ".$this->carbon );

        return $this->updateDataVB();
    }

    public function updateDataVB(){
        try{
            DB::beginTransaction();
            $ads = $this->ctrlSellAds->getAdsByBands( true );
            $totalAds = count( $ads );

            if( $totalAds > 0 ){

                Value_Band::truncate();

                for( $i = 0,$j = $totalAds; $i < $j; $i++ ){
                    $data = [
                        'val_cambio' => $ads[$i]['price'],
                        'bank_id'    => $ads[$i]['bank_id'],
                        'band_id'    => $ads[$i]['band_id'],
                    ];
                    Value_Band::create( $data );
                }

            }

        }catch ( \Exception $e ){
            DB::rollBack();
            \Log::error("Error! - Cron update / value_bands ".$e->getMessage() ." - At ".$this->carbon );
        }
        DB::commit();
        //\Log::info("Finish - Successfully! / Cron update value_bands - At ".$this->carbon );
    }

    public function fillAvgCron(){
        ini_set('max_execution_time', 900);
        try{
            DB::beginTransaction();
            $avg = $this->ctrlSellAds->getAvgBtcCur();

            if( !is_null( $avg ) ){
                if( isset( $avg->VES ) ){
                    $dataVes = [
                        "avg_12h"    => $avg->VES->avg_12h,
                        "volume_btc" => $avg->VES->volume_btc,
                        "avg_24h"    => $avg->VES->avg_24h,
                        "avg_1h"     => $avg->VES->avg_1h,
                        "last"       => $avg->VES->rates->last,
                        "avg_6h"     => $avg->VES->avg_6h,
                        'currency'   => 'VES',
                        'json'       => json_encode($avg->VES)
                    ];
                    Avg::create( $dataVes );
                }

                if( isset( $avg->USD ) ){
                    $dataUsd = [
                        "avg_12h"    => $avg->USD->avg_12h,
                        "volume_btc" => $avg->USD->volume_btc,
                        "avg_24h"    => $avg->USD->avg_24h,
                        "avg_1h"     => $avg->USD->avg_1h,
                        "last"       => $avg->USD->rates->last,
                        "avg_6h"     => $avg->USD->avg_6h,
                        'currency'   => 'USD',
                        'json'       => json_encode($avg->USD)
                    ];
                    Avg::create( $dataUsd );
                }
            }
            DB::commit();
            //\Log::info('Cron fill avg Successfully at '.$this->carbon);
        }catch( \Exception $e ){
            DB::rollBack();
            \Log::error('Cron fill avg failed at - '.$e->getMessage().' '.$this->carbon);
        }
    }

    public function getOrderBook(){
        ini_set('max_execution_time', 900);
        try{
            DB::beginTransaction();
            $orderBooks = Curl::to( env('URL_BASE_API') . '/bitcoincharts/VES/orderbook.json' )->get();
            $orderJson  = json_decode( $orderBooks );

            if( isset( $orderJson->bids ) && isset( $orderJson->asks ) ){
                $totalBids = count( $orderJson->bids );
                $totalAsks = count( $orderJson->asks );
                $sumBids = 0;
                $sumAsks = 0;
                $avgBids = 0;
                $avgAsks = 0;
                $minBids = 0;
                $maxBids = 0;
                $minAsk  = 0;
                $maxAsk  = 0;
                $arrayBids = [];
                $arrayAsks = [];

                if( $totalBids > 0 ){

                    for( $i = 0,$j = $totalBids; $i < $j; $i++ ){
                        if( $this->checkRangePrice( $orderJson->bids[$i][0] ) ){
                            $arrayBids[] = $orderJson->bids[$i][0];
                            $sumBids = $sumBids + (float)$orderJson->bids[$i][0];
                        }
                    }

                }

                if( $totalAsks > 0 ){

                    for( $i = 0,$j = $totalAsks; $i < $j; $i++ ){
                        if( $this->checkRangePrice( $orderJson->asks[$i][0] ) ){
                            $arrayAsks[] = $orderJson->asks[$i][0];
                            $sumAsks = $sumAsks + (float)$orderJson->asks[$i][0];
                        }
                    }

                }

                //avgs
                $avgBids = $sumBids / $totalBids;
                $avgAsks = $sumAsks / $totalAsks;
                //max - min
                $maxBids = max( $arrayBids );
                $minBids = min( $arrayBids );
                $maxAsk  = max( $arrayAsks );
                $minAsk  = min( $arrayAsks );

                OrderBook::create([
                    'min_bid' => (float)$minBids,
                    'max_bid' => (float)$maxBids,
                    'avg_bid' => (float)$avgBids,
                    'min_ask' => (float)$minAsk,
                    'max_ask' => (float)$maxAsk,
                    'avg_ask' => (float)$avgAsks
                ]);
            }
        }catch( \Exception $e ){
            DB::rollBack();
            \Log::error("Error! - OrderBook ".$e->getMessage() ." - At ".$this->carbon );
        }
        DB::commit();
       // \Log::info("Finish - Successfully! / OrderBook - At ".$this->carbon );
    }

    public function checkRangePrice($price){

        $lbc = Avg::where('currency','VES')->get()->last()->toArray();
        $valueLbc = $lbc['avg_24h'] == 0 || $lbc['avg_24h'] == null ? $lbc['avg_12h'] : $lbc['avg_24h'];
        $percen = calculatePercentage( $valueLbc );

        if( $price > ( $valueLbc - $percen ) &&
            $price < ( $valueLbc + $percen ) ){
            return true;
        }

        else{
            return false;
        }
    }

    public function cronUpdateBands(){
        try{
            DB::beginTransaction();
            $bands = Band::all()->toArray();
            $totalRowBand = count($bands);

            if( $totalRowBand > 0 && !empty($bands) ){

                $data=[
                    'min_value_init' => $bands[0]['min'],
                    'max_value_init' => $bands[0]['max'],
                    'min_value_half' => $bands[1]['min'],
                    'max_value_half' => $bands[1]['max'],
                    'min_value_end'  => $bands[2]['min'],
                    'max_value_end'  => $bands[2]['max'],
                ];

                History_Bands::create( $data );
            }

            $avgS = Avg::whereCurrency('VES')->get();
            $avgD = Avg::whereCurrency('USD')->get();
            $avgLS = $avgS->last();
            $avgLD = $avgD->last();

            if( isset($avgLS->avg_1h) && isset($avgLD->avg_1h) )
                $avgValue = $avgLS->avg_1h / $avgLD->avg_1h;
            else
                $avgValue = $avgLS->avg_24h / $avgLD->avg_24h;

            Band::whereId(1)->update([
                'min' => 0,
                'max' => $avgValue * 100
            ]);

            Band::whereId(2)->update([
                'min' => ($avgValue * 100) + 1,
                'max' => $avgValue * 500
            ]);

            Band::whereId(3)->update([
                'min' => ($avgValue * 500) + 1,
                'max' => -1
            ]);
            DB::commit();
        }catch ( \Exception $e ){
            DB::rollBack();
            \Log::error("Error! - UpdateBands ".$e->getMessage() ." - At ".$this->carbon );
        }
        //\Log::info("Finish - Successfully! / UpdateBands - At ".$this->carbon );
    }
}
