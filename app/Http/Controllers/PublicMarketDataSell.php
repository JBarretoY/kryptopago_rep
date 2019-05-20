<?php

namespace App\Http\Controllers;
use App\Models\Bank;
use App\Models\Cron;
use Ixudra\Curl\Facades\Curl;
use App\Models\Band;

class PublicMarketDataSell extends Controller
{
    private $base_url;
    private $ad_list;
    private $list_mercantil;
    private $list_banesco;
    private $list_bod;
    private $list_bnc;
    private $list_provincial;
    private $avg_mercantil;
    private $avg_banesco;
    private $avg_bod;
    private $avg_bnc;
    private $avg_provincial;
    private $bands;
    private $bank_ids;
    private $bank_names;

    public function __construct(){
        $this->base_url = env('URL_BASE_API');
        $this->ad_list  = [];
        $this->list_mercantil = [];
        $this->list_banesco   = [];
        $this->list_bod = [];
        $this->list_bnc = [];
        $this->list_provincial = [];
        $this->avg_mercantil   = [];
        $this->avg_banesco = [];
        $this->avg_bod = [];
        $this->avg_bnc = [];
        $this->avg_provincial = [];
        $this->bands = [];
        $this->bank_ids = [];
        $this->bank_names = [];
        $this->getBands();
        $this->getBanks();
    }

    public function addArrayAds($bankName,$price, $min, $max,$band_id,$bank_id){
        $item = ['bankname' => $bankName,
                 'price'    => $price,
                 'min'      => $min,
                 'max'      => $max,
                 'band_id'  => $band_id,
                 'bank_id'  => $bank_id];

        if ( !in_array($item, $this->ad_list) ) {
            $this->ad_list[] = $item;

            if( $bankName == 'Mercantil' )
                $this->list_mercantil[] = $item;

            else if( $bankName == 'Banesco' )
                $this->list_banesco[] = $item;

            else if( $bankName == 'BOD' )
                $this->list_bod[] = $item;

            else if( $bankName == 'BNC' )
                $this->list_bnc[] = $item;

            else if( $bankName == 'Provincial' )
                $this->list_provincial[] = $item;
        }
    }

    /*public function addAvgAds($list, $bankName){
        $arr = []; // [ 'band' => [ 'min' => 121001, 'max' => -1], 'prices' => [45, 12, 2, 3, 25] ]

        for( $i = 0,$y = count($list); $i < $y; $i++ ){

            $min = $list[$i]['min'];
            $max =  $list[$i]['max'];
            $price = $list[$i]['price'];
            $found = false;
            for ($j=0; $j < count($arr); $j++){
                if ($arr[$j]['band']['min'] == $min && $arr[$j]['band']['max'] == $max){
                    $found = true;
                    $arr[$j]['prices'][] = $price;
                    break;
                }
            }

            if (!$found){
                $arr[] = [ 'band' => [ 'min' => $min, 'max' => $max ], 'prices' => [$price] ];
            }

        }

        for( $i = 0,$y = count($arr); $i < $y; $i++ ){

            $p = array_sum($arr[$i]['prices'])/count($arr[$i]['prices']);
            $item = ['bank' => $bankName, 'band' => $arr[$i]['band'], 'avg' => $p];

            if( $bankName == 'Mercantil' )
                $this->avg_mercantil[] = $item;

            else if( $bankName == 'Banesco' )
                $this->avg_banesco[] = $item;

            else if( $bankName == 'BOD' )
                $this->avg_bod[] = $item;

            else if( $bankName == 'BNC' )
                $this->avg_bnc[] = $item;

            else if( $bankName == 'Provincial' )
                $this->avg_provincial[] = $item;
        }
    }*/

    public function getBands(){
        $fetch = Band::all();
        $bands = [];

        for( $i=0; $i < count( $fetch ); $i++ ){
            $bands[$i]['min'] = $fetch[$i]->min;
            $bands[$i]['max'] = $fetch[$i]->max;
            $bands[$i]['id']  = $fetch[$i]->id;
        }

        $this->bands = $bands;
    }

    public function getBanks(){
        $fetch = Bank::all();
        $bank_ids = [];
        $bank_names = [];

        for( $i=0; $i < count($fetch); $i++ ){
            $bank_ids[]   = $fetch[$i]->id;
            $bank_names[] = strtoupper($fetch[$i]->name);
        }

        $this->bank_ids = $bank_ids;
        $this->bank_names = $bank_names;
    }

    public function checkValueByBand($val,$bankName,$price){

        $bands = $this->bands;
        $bank_pos = array_search(strtoupper($bankName),$this->bank_names);

        if( $bank_pos !== false ){
            $bank_id  = $this->bank_ids[$bank_pos];

            for( $i = 0,$y = count($bands); $i < $y; $i++ ){

                if( $bands[$i]['max'] == -1 ) {
                    if ( $val >= $bands[$i]['min'] )
                        $this->addArrayAds($bankName, $price, $bands[$i]['min'], $bands[$i]['max'],$bands[$i]['id'],$bank_id);
                }else{
                    if( $val >= $bands[$i]['min'] && $val <= $bands[$i]['max'] )
                        $this->addArrayAds($bankName,$price, $bands[$i]['min'], $bands[$i]['max'],$bands[$i]['id'],$bank_id);
                }
            }
        }
    }

    public function getAdsByBands( $bool=false ){
        try{
            $respJson = Cron::all();
            $countAds = count( $respJson );

            if( $countAds >= 1 ){
                $cMer = $cBan = $cPro = $cBn = $cBo = 0;
                for( $i = 0,$j = $countAds; $i < $j; $i++ ){

                    $min = $respJson[$i]->min_amount;
                    $max = $respJson[$i]->max_amount;
                    $nameBank  = strtoupper( $respJson[$i]->bank_name );
                    $tempPrice = $respJson[$i]->temp_price;

                    if($cMer <= 10){
                        if( stripos($nameBank, "mercantil" ) !== false ){
                            $this->checkValueByBand($min,'Mercantil',$tempPrice);
                            $this->checkValueByBand($max,'Mercantil',$tempPrice);
                            $cMer++;
                        }
                    }

                    if($cBan <= 10){
                        if( stripos($nameBank, "banesco" ) !== false ){
                            $this->checkValueByBand($min,'Banesco',$tempPrice);
                            $this->checkValueByBand($max,'Banesco',$tempPrice);
                            $cBan++;
                        }
                    }

                    if($cBn <= 10){
                        if( stripos($nameBank, "bnc" ) !== false ){
                            $this->checkValueByBand($min,'BNC',$tempPrice);
                            $this->checkValueByBand($max,'BNC',$tempPrice);
                            $cBn++;
                        }
                    }

                    if($cPro <= 10){
                        if( stripos($nameBank, "provincial" ) !== false ){
                            $this->checkValueByBand($min,'Provincial',$tempPrice);
                            $this->checkValueByBand($max,'Provincial',$tempPrice);
                            $cPro++;
                        }
                    }

                    if($cBo <= 10){
                        if( stripos($nameBank, "bod" ) !== false ){
                            $this->checkValueByBand($min,'BOD',$tempPrice);
                            $this->checkValueByBand($max,'BOD',$tempPrice);
                            $cBo++;
                        }
                    }
                }

            }else{
                return !$bool ? response()->json(['No ads']) : [];
            }
        }catch (\Exception $e){
            return response()->json(['msg' => 'Error']);
        }
        /*$this->addAvgAds($this->list_mercantil, 'Mercantil');
        $this->addAvgAds($this->list_banesco, 'Banesco');
        $this->addAvgAds($this->list_bod, 'BOD');
        $this->addAvgAds($this->list_bnc, 'BNC');
        $this->addAvgAds($this->list_provincial, 'Provincial');
        dd($this->avg_mercantil, $this->avg_banesco, $this->avg_bod, $this->avg_bnc, $this->avg_provincial)*/;

        return !$bool ? response()->json($this->ad_list) : $this->ad_list;
    }

    public function getBuyByBankSell($bank){
        try{
            $respJson = $this->getAdsAll();
            $countAds = count( $respJson );

            if( $countAds >= 1 ){
                $ads = [];
                //todo $countAds = $countAds-1;

                for( $i = 0, $j = $countAds; $i < $j ;$i++ ){
                    if( preg_match("/$bank/i",$respJson[$i]->bank_name ) ){
                        $ads[] = $respJson[$i];
                    }
                }
            }else{
                return response()->json(['data' => ""]);
            }
        }catch (\Exception $e){
            return response()->json('error',500);
        }

        return response()->json(['data' => $ads,'total_ads' => count($ads)]);
    }

    public function getAdsGroupBankSell(){
        try{
            $respJson = $this->getAdsAll();
            $countAds = count( $respJson );

            if( $countAds >= 1 ){
                $adsVen = [];
                $adsBan = [];
                $adsMer = [];

                for( $i = 0, $j = $countAds; $i < $j ;$i++ ){
                    if( preg_match("/mercantil/i",$respJson[$i]->bank_name ) ){
                        $adsMer[] = $respJson[$i];
                    }

                    if( preg_match("/banesco/i",$respJson[$i]->bank_name ) ){
                        $adsBan[] = $respJson[$i];
                    }

                    if( preg_match("/venezuela/i",$respJson[$i]->bank_name ) ){
                        $adsVen[] = $respJson[$i];
                    }
                }

                $dataArray = [
                    [
                        'Mercantil_ads' => $adsMer,
                        'total_ads'     => count($adsMer)
                    ],
                    [
                        'Banesco_ads'  => $adsBan,
                        'total_ads'    => count($adsBan)
                    ],
                    [
                        'Venezuela_ads' => $adsVen,
                        'total_ads'     => count($adsVen)
                    ]
                ];
            }else{
                return response()->json( ['data' => ""] );
            }

        }catch(\Exception $e){
            return response()->json('error',500);
        }
        return response()->json($dataArray);
    }

    public function getAdsAll(){
        try{
           $data=[];
           $dataArray=$this->getAllPages($this->base_url . '/sell-bitcoins-online/VES/.json', $data);
        }catch(\Exception $e){
            return response()->json('error',500);
        }

        $finalAds = [];

        foreach ($dataArray as $vale) {
           foreach ($vale as $ads) {
               $finalAds[] = $ads->data;
           }
        }

        return $finalAds;
    }

    public function getAllPages($url, &$data){
        try{
            $file = Curl::to($url)->get();
            $jsonData = json_decode($file);
            $data[] = $jsonData->data->ad_list;

            if( !empty( $jsonData->pagination->next ) )
            {
                $this->getAllPages($jsonData->pagination->next, $data);
            }

            return $data;


        }catch(\Exception $e){
            return response()->json('error',500);
        }
    }

    public function getAvgBtcCur(){
        $avg     = Curl::to( $this->base_url . '/bitcoinaverage/ticker-all-currencies/' )->get();
        $avgJson = json_decode( $avg );

        if( !is_null($avgJson) && !empty($avgJson) )
            return $avgJson;
        else
            return null;
    }
}
