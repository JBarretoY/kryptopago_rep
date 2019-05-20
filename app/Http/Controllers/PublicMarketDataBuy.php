<?php

namespace App\Http\Controllers;
use Ixudra\Curl\Facades\Curl;

class PublicMarketDataBuy extends Controller
{
    private $base_url;

    public function __construct(){
        $this->base_url = env('URL_BASE_API');
    }

    /**
     * @param $bank
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBuyByBankBuy($bank){
        try{
            $resp = Curl::to($this->base_url . '/buy-bitcoins-online/VES/.json')->get();
            $respJson = json_decode($resp,TRUE);
            $countAds = count($respJson['data']['ad_list']);

            if( $countAds >= 1 ){
                $ads = [];
                $countAds = $countAds-1;

                for( $i = 0, $j = $countAds; $i < $j ;$i++ ){
                    if( preg_match("/$bank/i",$respJson['data']['ad_list'][$i]['data']['bank_name']) ){
                        $ads[] = $respJson['data']['ad_list'][$i]['data'];
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

    public function getAdsGroupBankBuy(){
        try{
            $resp = Curl::to($this->base_url . '/buy-bitcoins-online/VES/.json')->get();
            $respJson = json_decode($resp,TRUE);
            $countAds = count($respJson['data']['ad_list']);

            if( $countAds >= 1 ){
                $adsVen = [];
                $adsBan = [];
                $adsMer = [];

                for( $i = 0, $j = $countAds; $i < $j ;$i++ ){
                    if( preg_match("/mercantil/i",$respJson['data']['ad_list'][$i]['data']['bank_name']) ){
                        $adsMer[] = $respJson['data']['ad_list'][$i]['data'];
                    }

                    if( preg_match("/banesco/i",$respJson['data']['ad_list'][$i]['data']['bank_name']) ){
                        $adsBan[] = $respJson['data']['ad_list'][$i]['data'];
                    }

                    if( preg_match("/venezuela/i",$respJson['data']['ad_list'][$i]['data']['bank_name']) ){
                        $adsVen[] = $respJson['data']['ad_list'][$i]['data'];
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
                return response()->json(['data' => ""]);
            }

        }catch(\Exception $e){
            return response()->json('error',500);
        }
        return response()->json($dataArray);
    }
}
