<?php
/**
 * Created by PhpStorm.
 * User: Simorg
 * Date: 12/11/2018
 * Time: 2:05 PM
 */

namespace App\Repositories;
use App\Models\User;

class UserRepository
{
    public function storeUser( $request )
    {
        return User::create( $request );
    }

    public function updateUser( $id, $data )
    {
        $user = User::find($id);
        $up   = $user->update($data);
        return $up ? $user->refresh() : $up;
    }

    public function getUser($id)
    {
        return User::where('id',$id)->first();
    }

    public function deleteUser($id)
    {
        $user = User::where('id',$id)->first();

        return is_null($user) ? null : $user->delete();
    }

    public function getUsers(){
        return User::orderBy('id', 'desc')->get();
        //return Commerce::with('users')->orderBy('id', 'desc')->paginate(10);
    }

    public function getUsersCommerce($commerce_id){
        return User::with('wallets')->where('commerce_id',$commerce_id)->orderBy('id', 'desc')->get();
    }

    public function checkUserReg($token,$pass){
        $user = User::where('id',$token[0])->where('checked',0)->first();

        return is_null($user) ? null : $user->update(['password' => bcrypt($pass), 'checked' => 1]);
    }

    public function verify_token($arrToken){
        $user = User::whereId( $arrToken[0] )->where(function($query){
            $query->where('checked',0)->orWhere('checked',3);
        })->first();

        return is_null($user) ? false : true;
    }

    public function userExist($email) {
        return User::where('email',$email)->first();
    }

    public function getUserCommerceNoWalletRepo(){
        $userAuthId = currentUser()->commerce_id;

        return !is_null($userAuthId) ?
            User::doesntHave('wallets')->with('commerce')->where('commerce_id', $userAuthId)->paginate(10) : 401;
    }

    public function upPass($id,$password){
        return User::where('id',$id)->update(['password' => bcrypt($password),'checked' => 1]);
    }

    public function upMail($id,$mail){
        return User::where('id',$id)->update(['email' => $mail]);
    }

    public function changeStastus2pass($email){
        $user = User::whereEmail($email)->first();
        $user->checked = 3; // 3 is for change pass
        $user->save();

        if( (integer) $user->type === 3 ){
            $usersCo = $this->getUsersOwnCommerce($user->commerce_id);
            return $usersCo->toArray();
        }

        return $user->refresh();
    }

    public function getUsersOwnCommerce($commerce_id){
        return User::whereCommerceId($commerce_id)
               ->where('type',2)
               ->get();
    }
}
