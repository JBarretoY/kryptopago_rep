<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TransactionRepository;
use App\Repositories\CommerceRepository;
use App\Repositories\AvgRepository;
use DB;

class TransactionController extends Controller
{
    private $trans;
    private $commerce;
    private $avg;

    public function __construct(TransactionRepository $trans, CommerceRepository $commerce, AvgRepository $avg)
    {
        $this->trans    = $trans;
        $this->commerce = $commerce;
        $this->avg      = $avg;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = currentUser();

        if ($user->type === 2)
            $trans = $this->trans->indexTransCommerce($user->commerce_id);
        elseif ($user->type === 3)
            $trans = $this->trans->userTransaction($user->id);
        else
            $trans = $this->trans->index();

        if ($trans)
            return response()->json( ['transaction' => $trans],200 );
        else
            return response()->json(['message' => 'No data'],400);
    }

    public function indexNoValidate()
    {
        $user = currentUser();

        if ($user->type === 2)
            $trans = $this->trans->indexTransCommerceNV($user->commerce_id);
        elseif ($user->type === 3)
            $trans = $this->trans->userTransactionNV($user->id);
        else
            $trans = $this->trans->indexNV();

        if ($trans)
            return response()->json( ['transaction' => $trans],200 );
        else
            return response()->json(['message' => 'No data'],400);
    }
    /*public function index()
    {
        $user = currentUser();

        if ($user->type === 2)
            $trans = $this->trans->indexTransCommerce($user->commerce_id);
        elseif ($user->type === 3)
            $trans = $this->trans->userTransaction($user->id);
        else{
            $trans = $this->trans->index();
            if ($trans)
                return response()->json( ['comemrce' => $trans],200 );
            else
                return response()->json(['message' => 'No data'],400);
        }

        if ($trans)
            return response()->json( ['transaction' => $trans],200 );
        else
            return response()->json(['message' => 'No data'],400);
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = currentUser();
        DB::beginTransaction();
        $data = ['amount_bs'     => $request->input('amount_bs'),
                 'amount_crypto' => $request->input('amount_crypto'),
                 'reference'     => is_null($request->input('reference')) ? null : $request->input('reference'),
                 'btc_value'     => $request->input('btc_value'),
                 'txid'          => is_null($request->input('txid')) ? null : $request->input('txid'),
                 'commerce_id'   => $user->commerce_id,
                 'user_id'       => $user->id,
                 'wallet_id'     => $request->input('wallet_id'),
                 'bank_id'       => $request->input('bank_id'),
                 'band_id'       => $request->input('band_id'),
                 'validate'      => is_null($request->input('txid')) ? 0 : 1];

        $transaction = $this->trans->store($data);

        if (!$transaction) {
            return response()->json('error',400);
        }else{
            $up = ['VES' => $request->input('amount_bs'),
                   'BTC' => $request->input('amount_crypto'),
                   'id'  => $user->commerce_id];

            $upCommer = $this->commerce->updateTotals($up);
            if ($upCommer){
                DB::commit();
                return response()->json(['transaction'=>$transaction],201);
            }else
                return response()->json('error',400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param $transaction_id
     * @return \Illuminate\Http\Response
     */
    public function show($transaction_id)
    {
        $trans = $this->trans->show($transaction_id);

        if (is_null($trans)) {
            return response()->json('not found',404);
        }

        return response()->json($trans,200);
    }

    /**
     * @param Request $request
     * @param $transaction_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $transaction_id)
    {
        $data = [
                 'txid'          => $request->input('txid'),
                 'validate'      => true
                ];

        $trans = $this->trans->show($transaction_id);

        if (is_null($trans)) {
            return response()->json('not found',404);
        }

        $resp = $this->trans->update($transaction_id,$data);

        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message'=>'error'],400);
    }

    /**
     * @param $transaction_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($transaction_id)
    {
        $trans = $this->trans->show($transaction_id);

        if (is_null($trans)) {
            return response()->json('not found',404);
        }

        $trans->delete();

        return response()->json(null, 200);
    }

    public function getDataFilter( $params ){
        $paramsArray = $this->parseParams2Array( $params );

        if( gettype( $paramsArray ) == 'array' && count($paramsArray) >= 1 ){

            if( $this->validFilterDate( $paramsArray ) ){
                $resp = $this->trans->doFilteredTrans( $paramsArray );
            }else{

                return response()->json(['message'=>'Bad Request'],400);
            }

        }else
            return response()->json(['message'=>'Bad Request'],400);

        return response()->json( $resp,200 );
    }

    public function validFilterDate($dt){

        if( ( isset( $dt['dateI'] ) && !isset( $dt['dateE'] ) ) || ( !isset( $dt['dateI'] ) && isset( $dt['dateE'] ) ) )
            return false;
        else
            return true;

    }

    public function parseParams2Array( $params ){
        $arrayParams = explode('&',$params);
        $arrayData = [];

        if( count($arrayParams) > 0 ){
            for( $i=0; $i < count( $arrayParams );$i++ ){
                $dataEx = explode('=',$arrayParams[$i]);

                if( count($dataEx) > 1 ){
                    $arrayData[$dataEx[0]] = $dataEx[1];
                }
            }

            return $arrayData;
        }

        return false;
    }

    public function dashboard(){
        $user = currentUser();
        $btc  = 0;
        $ves  = 0;

        if ($user->type === 2 || $user->type === 3){
            if ($user->type === 2)
                $oper = $this->trans->indexTransCommerce($user->commerce_id);
            else
                $oper = $this->trans->userTransaction($user->id);
                

            if ($oper){
                for ($i=0; $i < count($oper); $i++) { 
                    $btc = $btc + $oper[$i]->amount_crypto;
                    $ves = $ves + $oper[$i]->amount_bs;
                }

                return response()->json( ['numero_operaciones' => count($oper),'volumen_btc'=>$btc,'volumen_bs'=>$ves, 'tasa_del_dia' => 0],200 ); //falta
            }
            else
                return response()->json(['message' => 'No data'],400);
        }else{
            $oper    = $this->trans->index();
            $trans24 = $this->trans->trans24();
            $commerce= $this->commerce->indexCommerce();
            if ($oper){
                for ($i=0; $i < count($oper); $i++) { 
                    $btc = $btc + $oper[$i]->amount_crypto;
                    $ves = $ves + $oper[$i]->amount_bs;
                }

                $avg      = $this->avg->lastAvg();
                $alto     = $trans24->max('btc_value');
                $bajo     = $trans24->min('btc_value');
                $vol      = $trans24->sum('btc_value');
                $cambio   = (($trans24->last()->btc_value - $trans24->first()->btc_value) / $trans24->first()->btc_value) * 100;
                $valor    = $commerce->sum('total_VES_by_BTC');
                $cantidad = $commerce->sum('total_BTC');


                return response()->json( ['numero_operaciones' => count($oper),'volumen_btc'=>$btc,'volumen_bs'=>$ves, 'tasa_del_dia' => $avg->avg_24h,'alto' => $alto,'bajo' => $bajo, 'volumen' => $vol, 'cambio' => $cambio, 'valor' => $valor, 'cantidad' => $cantidad],200 ); 
            }else
                return response()->json(['message' => 'No data'],400);
        }
    }
}
