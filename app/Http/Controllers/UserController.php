<?php

namespace App\Http\Controllers;
use App\Repositories\UserRepository;
use App\Repositories\User_WalletRepository;
use App\Repositories\CommerceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UserController extends Controller
{
    private $user;
    private $user_wallet;
    private $commerce;

    public function __construct( UserRepository $user, User_WalletRepository $user_wallet, CommerceRepository $commerce)
    {
        $this->user        = $user;
        $this->user_wallet = $user_wallet;
        $this->commerce    = $commerce;
    }

    public function store( Request $request )
    {
        $user = currentUser();

        $exist = $this->user->userExist($request->email);

        if ($exist)
            return response()->json(['message' => 'Este usuario ya existe'],422);

        $data = ['name'             =>  $request->name,
                 'lastname'         =>  $request->lastname,
                 'email'            =>  $request->email,
                 'type'             =>  $request->type,
                 'password'         =>  bcrypt($request->password),
                 'phone'            =>  $request->phone,
                 'commerce_id'      =>  $user->commerce_id,
                 'last_sesion'      =>  date('Y-m-d'),
                 'checked'          =>  1
                ];

        $resp = $this->user->storeUser( $data);

        if( $resp ){
            $commerce = $this->commerce->showCommerce($user->commerce_id);
            $mail = New MailSender();
            $mail->sendMailRegisterByAdmin($commerce->name,$request->email);
            return response()->json($resp,201);
        }
        else
            return response()->json(['message'=>'error'],500);
    }

    public function update( $id, Request $request )
    {
        $user1   = $this->user->getUser($id);
        $request = $request->all();
        $mail    = false;

        if ($user1){
            if ($user1->email != $request['email']){
                $exist = $this->user->userExist($request['email']);
                if ($exist)
                    return response()->json(['message'=>'El email ya se encuentra en uso'],404);
                else{

                    if (isset($request['password'])){
                        $data = [
                            'name'        => $request['name'],
                            'lastname'    => $request['lastname'],
                            'email'       => $request['email'],
                            'password'    => bcrypt($request['password']),
                            'type'        => $request['type'],
                            'phone'       => $request['phone'],
                            'last_sesion' => date('Y-m-d')
                        ];
                        $mail = true;
                    }else{
                        $data = [
                            'name'        => $request['name'],
                            'lastname'    => $request['lastname'],
                            'email'       => $request['email'],
                            'type'        => $request['type'],
                            'phone'       => $request['phone'],
                            'last_sesion' => date('Y-m-d')
                        ];
                    }
                    
                    $resp = $this->user->updateUser( $id, $data );

                    if( $resp ){
                        if ($mail){
                            $mail = New MailSender();
                            $mail->sendMailChangePassByAdmin($request['name'],$request['email']);
                        }
                        return response()->json($resp,200);
                    }
                    else
                        return response()->json(['message'=>'error'],400);
                }
            }else{
                
                if (isset($request['password'])){
                        $data = [
                            'name'        => $request['name'],
                            'email'       => $request['email'],
                            'password'    => bcrypt($request['password']),
                            'type'        => $request['type'],
                            'phone'       => $request['phone'],
                            'last_sesion' => date('Y-m-d')
                        ];
                        $mail = true;
                    }else{
                        $data = [
                            'name'        => $request['name'],
                            'email'       => $request['email'],
                            'type'        => $request['type'],
                            'phone'       => $request['phone'],
                            'last_sesion' => date('Y-m-d')
                        ];
                    }
                    
                    $resp = $this->user->updateUser( $id, $data );

                if( $resp ){
                    if ($mail){
                        $mail = New MailSender();
                        $mail->sendMailChangePassByAdmin($request['name'],$request['email']);
                    }
                    return response()->json($resp,200);
                }
                else
                    return response()->json(['message'=>'error'],400);
            }
        }else
            return response()->json(['message'=>'Usuario no encontrado'],404);
    }

    public function destroy( $id)
    {
        $resp = $this->user->deleteUser( $id );

        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message'=>'Usuario no encontrado'],404);
            
    }

    public function index()
    {
        $user = currentUser();

        if ($user->type === 1)
            $data = $this->user->getUsers();
        elseif ($user->type === 2)
            $data = $this->user->getUsersCommerce($user->commerce_id);
        else
            return response()->json(['message' => 'Usuario no autorizado'],400);

        if ($data)
            return response()->json(['users' => $data],200);
        else
            return response()->json(['message' => 'No existen datos registrados'],200);
    }
    /*public function index()
    {
        $user = currentUser();

        if ($user->type === 1){
            $data = $this->user->getUsers();
            if ($data)
                return response()->json(['commerce' => $data],200);
            else
                return response()->json(['message' => 'No existen datos registrados'],200);
        }
        elseif ($user->type === 2)
            $data = $this->user->getUsersCommerce($user->commerce_id);
        else
            return response()->json(['message' => 'Usuario no autorizado'],400);

        if ($data)
            return response()->json(['users' => $data],200);
        else
            return response()->json(['message' => 'No existen datos registrados'],200);
    }*/

    public function show( Request $request ){
        $resp = $this->user->getUser( $request->all() );

        if( $resp )
            return response()->json($resp,200);
        else
            return response()->json(['message'=>'Usuario no encontrado'],404);
    }

    public static function genToken2ValidUser($id,$name,$email,$lastname){
        $strToken = $id."@#$%$".$name."@#$%$".$email;
        $token = Crypt::encrypt( $strToken );
        $mail  = New MailSender();
        $namem = $name.' '.$lastname;
        $mail->sendMailRegister($namem,$email,$token);
    }

    public function checkToken2User($token,Request $request){
        try{
            $resp = '';
            $flag = 0;
            $userArr = explode('@#$%$',Crypt::decrypt($token));
            $respTemp = $this->user->checkUserReg($userArr,$request->input('password'));

            if( is_null($respTemp) ){
                $resp = ['message'=>'token invalid','status' => 400];
            }
            else{
                $resp = ['message'=>'password valid','status' => 200];
                $flag = 1;
            }
        }catch ( DecryptException $e ){
            return response()->json(['message'=>'token invalid','status' => 400],400);
        }
        return response()->json( $resp, ($flag == 1) ? 200 : 400 );
    }

    public function verify_token($token){
        try{
            $dataToken = Crypt::decrypt( $token );
            $tokenExplode = explode('@#$%$',$dataToken);
            $resp = $this->user->verify_token($tokenExplode);

            if( $resp )
                return response()->json( ['message'=>'token valid', 'status'=>200],200 );
            else
                return response()->json( ['message' => 'token expired','status' => 400],400 );
        }catch ( DecryptException $e ){
            return response()->json( ['message' => 'token expired','status' => 400],400 );
        }
    }

    public function associateWallet (Request $request){

        $can = $this->user_wallet->associateExist($request->input('wallet_id'));

        if (is_null($can)){

            $data = ['user_id'   => $request->input('user_id'), 
                     'wallet_id' => $request->input('wallet_id')];

            $asso = $this->user_wallet->associate($data);

            if (is_null($asso)) 
                return response()->json(['message'=>'error'],400);
            else
                return response()->json($data,201);

        }else
            return response()->json(['message' => 'Esta Wallet ya se encuentra asociada'],400);
        
    }

    public function disassociate (Request $request){
        $data = ['user_id' => $request->user_id,
                 'wallet_id'     => $request->wallet_id];

        $dis = $this->user_wallet->disassociate($data);

        if ($dis)
            return response()->json($dis,200);
        else
            return response()->json(['message' => 'error'],400);
    }

    public function getUserCommerceNoWallet(){
        $resp = $this->user->getUserCommerceNoWalletRepo();

        if( gettype($resp) == 'object' )
            return response()->json( ['user' => $resp] ,200 );
        else
            return response()->json(['message' => 'No autorizado'],401);
    }

    public function changePass(Request $request){
        $user = currentUser();
        $data = [
            'email'    => $user->email,
            'password' => $request->old_pass
        ];
        if (auth()->attempt($data)){
            $up = $this->user->upPass($user->id,$request->new_pass);
            if ($up){
                $mail = New MailSender();
                $mail->sendMailChangePass($user->name,$user->email);
                return response()->json($up,200);
            }
            else
                return response()->json(['message' => 'error'],400);
        }
        else
            return response()->json(['message' => 'Contraseña incorrecta'],400);
    }

    public function changeMail(Request $request){
        $user = currentUser();
        $data = [
            'email'    => $user->email,
            'password' => $request->password
        ];
        if (auth()->attempt($data)){
            $up = $this->user->upMail($user->id,$request->new_email);
            if ($up){
                $mail = New MailSender();
                $mail->sendMailChangeMailold($user->name,$user->email);
                $mail->sendMailChangeMainew($user->name,$request->new_email);
                return response()->json($up,200);
            }
            else
                return response()->json(['message' => 'error'],400);
        }
        else
            return response()->json(['message' => 'Contraseña incorrecta'],400);
    }

    //#####PASSWORD-RESET
    public function initRecuePassNologin(Request $request){

        if( !is_null( $request->input('email') ) && $request->input('email') != '' ){

            if( !is_null( $this->user->userExist( $request->input('email') ) ) ){

                $user  = $this->user->changeStastus2pass( $request->input('email') );

                if( gettype($user) == 'array' ){

                    if( count($user) >= 1 ){

                        $userRescue = $this->user->userExist( $request->input('email') );
                        $sendEmail  = new MailSender();

                        for( $i=0;$i < count($user); $i++ ){
                            $sendEmail->sendMail2UserAdminCommerce($user[$i]['email'],$user[$i]['name'],$userRescue->name);
                        }

                        return response()->json(['message' => 'Email enviado'],200);
                    }else
                        return response()->json(['message' => 'usuario sin admin'],400);

                }else{
                    $token = generateToken2user($user->id,$user->name,$user->email);
                    $mail  = new MailSender();
                    $mail->sendMailRescuePassNoLogin($user->name,$user->email,$token);
                    return response()->json(['message' => 'Email enviado'],200);
                }
            }else
                return Response()->json(['message'=>'user not found'],404);

        }else
            return response()->json(['message'=>'email is required'],400);

    }

    public function rescuePassNoLog($token,Request $request){
        $dataToken = descrypToken2User($token);

        if( !is_null($dataToken) ){
            $user_id = $dataToken[0];
            $this->user->upPass($user_id,$request->input('password'));
            return response()->json(['message'=>'password updated'],200);
        }else
            return response()->json(['message'=>'token broken'],400);
    }
    //#####END PASSWORD-RESET

    public function resendEmailConfirm(Request $request){
        $user = $this->user->userExist($request->input('email'));

        if( !is_null( $user ) && (integer)$user->checked == 0 )
            self::genToken2ValidUser($user->id,$user->name,$user->email,$user->lastname);
        else
            return response()->json(['message'=>'este usuario ya esta confirmado'],400);

        return response()->json(['message'=>'email enviado'],200);
    }
}