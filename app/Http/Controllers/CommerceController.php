<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Repositories\CommerceRepository;
use App\Repositories\UserRepository;
use App\Repositories\Bank_CommerceRepository;

class CommerceController extends Controller
{
    private $commerce;
    private $user;
    private $bank_co;

    public function __construct( CommerceRepository $commerce, UserRepository $user, Bank_CommerceRepository $bank_co)
    {
        $this->commerce = $commerce;
        $this->user     = $user;
        $this->bank_co  = $bank_co;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = currentUser();
        if ($user->type === 1){
            $commerce = $this->commerce->indexCommerce();
            if ($commerce)
                return response()->json( ['commerce' => $commerce],200 );
            else
                return response()->json( ['message' => 'No data'],400 );
        }
        else
            return response()->json(['message' => 'Usario no autorizado'],400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store( Request $request ){
        $resp = $this->commerce->storeCommerce( $request->all() );
        if( $resp )
            return response()->json($resp,201);
        else
            return response()->json('error',500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $resp = $this->commerce->showCommerce( $request->all() );

        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message' => 'Commercio no encontrado'],404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $resp = $this->commerce->updateCommerce( $request->all() );
        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message' => 'Commercio no encontrado'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $resp = $this->commerce->destroyCommerce($request['id']);
        if( $resp != null )
            return response()->json($resp,200);
        else
            return response()->json(['message'=>'Commercio no encontrado'],404);
    }

    public function register( Request $request ){

        $exist = $this->user->userExist($request->email);

        if ($exist)
            return response()->json(['message' => 'Este usuario ya existe'],422);
        
        DB::beginTransaction();

        $comm = ['name'             =>  $request->commerce_name,
                 'email'            =>  $request->email,
                 'city'             =>  $request->city,
                 'rif'              =>  is_null($request->commerce_rif) ? null : $request->commerce_rif
                ]; 
        
        $respC = $this->commerce->storeCommerce($comm);

        if ( $respC ){

            $user = ['name'             =>  $request->name,
                     'lastname'         =>  $request->lastname,
                     'email'            =>  $request->email,
                     'type'             =>  2,
                     'password'         =>  bcrypt($request->email),
                     'phone'            =>  null,
                     'commerce_id'      =>  $respC->id,
                     'last_sesion'      =>  date('Y-m-d')
                    ];

            $respU = $this->user->storeUser($user);
            
            if ($respU){
                DB::commit();
                UserController::genToken2ValidUser($respU->id,$respU->name,$respU->email,$respU->lastname);
                return response()->json(['user' => $respU, 'commerce' => $respC],201);
            }else{
                DB::rollBack();
                return response()->json(['message'=>'Bad Request'],400);
            }
        }else{
            DB::rollBack();
            return response()->json(['message'=>'Bad Request'],400);
        } 

    }

    public function bank2commerce(Request $request){
        $save = [];
        $user = currentUser();
        $bank = explode(',', $request->input('bank'));

        DB::beginTransaction();

        $diss = $this->bank_co->disassociate($user->commerce_id);

        if($diss){
            if (!is_null($request->input('bank'))){

                for ($i=0; $i < count($bank) ; $i++) { 

                    $data = ['commerce_id' => $user->commerce_id,
                             'bank_id'     => $bank[$i]];

                    $save[] = $this->bank_co->associate($data);
                }

                if (count($save) === count($bank)){
                    DB::commit();
                    return response()->json(['bank_commerce' => $save],201);
                }
                else{
                    DB::rollBack();
                    return response()->json(['message' => 'error'],400);
                }
            }else
                return response()->json(['bank_commerce' => ''],201);
        }else{
            DB::rollBack();
            return response()->json(['message' => 'error'],400);
        }

        
    }

    public function disassociate ($bank_id){
        $user = currentUser();
        $data = ['commerce_id' => $user->commerce_id,
                 'bank_id'     => $bank_id];

        $dis = $this->bank_co->disassociate($data);

        if ($dis)
            return response()->json($dis,200);
        else
            return response()->json(['message' => 'error'],400);
    }

    public function betterRate(){
        $resp = $this->bank_co->getBetterRate();

        if( count( $resp ) > 0 )
            return response()->json($resp,200 );
        else
            return response()->json(['message'=>'no data'],400 );
    }
}
