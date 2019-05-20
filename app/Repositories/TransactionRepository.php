<?php

namespace App\Repositories;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Transaction::with('bank')->where('validate',true)->paginate(10);
        //return Commerce::with('transactions')->orderBy('id', 'desc')->paginate(10);
    }

    public function indexTransCommerce($commerce_id){
        return Transaction::with('bank')->where('commerce_id',$commerce_id)->where('validate',true)->orderBy('id', 'desc')->paginate(10);
    }

    public function userTransaction ($user_id){
        $query = Transaction::with('bank')->where('user_id',$user_id)->where('validate',true)->orderBy('id', 'desc')->paginate(10);
        return $query;
    }

    public function indexNV()
    {
        return Transaction::with('bank')->where('validate',false)->paginate(10);
        //return Commerce::with('transactions')->orderBy('id', 'desc')->paginate(10);
    }

    public function indexTransCommerceNV($commerce_id){
        return Transaction::with('bank')->where('commerce_id',$commerce_id)->where('validate',false)->orderBy('id', 'desc')->paginate(10);
    }

    public function userTransactionNV ($user_id){
        $query = Transaction::with('bank')->where('user_id',$user_id)->where('validate',false)->orderBy('id', 'desc')->paginate(10);
        return $query;
    }

    /**
     * @param array $data
     * @return Transaction
     */
    public function store($data)
    {
        $data['date'] = date('Y-m-d');

        return Transaction::create($data);
    }

    /**
     * @param int $id
     * @return Transaction|null
     */
    public function show($id)
    {
        return Transaction::whereId($id)->first();
    }

    /**
     * @param $id
     * @param $data
     * @return Transaction|false
     */
    public function update($id, $data)
    {
        $trans = Transaction::find($id);
        $up   = $trans->update($data);
        return $up ? $trans->refresh() : $up;
    }

    /**
     * @param $id
     * @return bool|mixed|null
     */
    public function destroy($id)
    {
        return Transaction::whereId($id)->delete();
    }


    public function doFilteredTrans( $params ){
        $query = new Transaction();

        if( isset($params['dateI']) && isset($params['dateE']) )
        {
            $query->where('created_at','ilike','%'.$params['dateI'].'%')
                  ->where('created_at','ilike','%'.$params['dateE'].'%');
        }

        if( isset( $params['reference'] ) )
            $query->where('reference',$params['reference']);

        if( isset( $params['amount_bs'] ) )
            $query->where('amount_bs',$params['amount_bs']);

        if( isset( $params['amount_crypto'] ) )
            $query->where('amount_crypto',$params['amount_crypto']);

        if( isset( $params['date'] ) )
            $query->where('date',$params['date']);

        if( isset( $params['cashier'] ) )
            $query->with( ['user' => function() use( $query,$params ){
                $query->where('type',3)->where('user_id',$params['cashier'] )
                ->get();
            }] );

        return $query->get();
    }

    public function trans24 (){
        $date = Carbon::now()->subHours('24');
        return Transaction::whereDate('created_at', '>=', $date)->get();
    }
}
