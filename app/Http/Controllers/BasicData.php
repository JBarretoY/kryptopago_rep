<?php

namespace App\Http\Controllers;
use Ixudra\Curl\Facades\Curl;

class BasicData extends Controller
{
    private $url;

    public function __construct(){
        $this->url = env('URL_BASE_API');
    }

    public function getCurrencies(){
        $resp = Curl::to($this->url.'/api/currencies/')->get();
        $finalResp = json_decode($resp,true);

        if( count($finalResp['data']['currencies']) >= 1 )
            return response()->json(['currencies' => $finalResp['data']['currencies'], 'total_currency' => $finalResp['data']['currency_count']]);
        else
            return response()->json(['data'=>'']);
    }

    public function getCountries(){
        $resp = Curl::to($this->url.'/api/countrycodes/')->get();
        $finalResp = json_decode($resp,true);

        if( count($finalResp['data']['cc_list']) >= 1 )
            return response()->json(['countries' => $finalResp['data']['cc_list'], 'total_countries' => $finalResp['data']['cc_count']]);
        else
            return response()->json(['data'=>'']);

    }

    public function getPaymentMethods(){
        $resp = Curl::to($this->url.'/api/payment_methods/')->get();
        $finalResp = json_decode($resp,true); //dd($finalResp);

        if( count($finalResp['data']['methods']) >= 1 )
            return response()->json(['methods' => $finalResp['data']['methods'], 'total_methods' => $finalResp['data']['method_count']]);
        else
            return response()->json(['data'=>'']);
    }
}
