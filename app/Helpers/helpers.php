<?php
/**
 * Created by PhpStorm.
 * User: Simorg
 * Date: 19/11/2018
 * Time: 3:16 PM
 */

function currentUser(){
    return auth()->user();
}

function calculatePercentage($value){
    return $value * env('PERCEN_VALUE') / 100;
}

function generateToken2user($id,$name,$email){
   $token = \Illuminate\Support\Facades\Crypt::encrypt($id.'@#$%$'.$name.'@#$%$'.$email);
   return $token;
}

function descrypToken2User($token){
    try {
        $decrypted = Crypt::decrypt($token);
        $arrayValues = explode('@#$%$',$decrypted);
    } catch (Illuminate\Contracts\Encryption\DecryptException $e){
        return null;
    }
    return $arrayValues;
}