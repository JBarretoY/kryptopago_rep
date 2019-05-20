<?php

namespace App\Http\Controllers;

use App\Mail\SenderMailRegister;
use App\Mail\SenderMailValidUser;
use App\Mail\SenderMailChangePass;
use Illuminate\Support\Facades\Mail;
use App\Mail\SenderMailChangeMailold;
use App\Mail\SenderMailChangeMailnew;
use App\Mail\SenderMailRecuePassCommerci;
use App\Mail\SenderMailChangePassNoLogin;
use App\Mail\sendMailChangePassByAdmin;
use App\Mail\sendMailRegisterByAdmin;

class MailSender extends Controller
{
    public function sendMailRegister($name,$email,$token){
        Mail::to($email)->send(new SenderMailRegister( $name,$token ));
    }

    public function sendMailCheckUser($name,$email,$token){
        Mail::to($email)
            ->send(new SenderMailValidUser($name,$token));
    }

    public function sendMailChangePass($name,$email){
        Mail::to($email)
            ->send(new SenderMailChangePass($name));
    }

    public function sendMailChangeMailold($name,$email){
        Mail::to($email)
            ->send(new SenderMailChangeMailold($name));
    }

    public function sendMailChangeMainew($name,$email){
        Mail::to($email)
            ->send(new SenderMailChangeMailnew($name));
    }

    public function sendMailRescuePassNoLogin($name, $email, $token){
        Mail::to($email)
            ->send( new SenderMailChangePassNoLogin($name,$token) );
    }

    public function sendMail2UserAdminCommerce($email,$admin,$cachier)
    {
        Mail::to($email)
            ->send(new SenderMailRecuePassCommerci($cachier, $admin));
    }

    public function sendMailChangePassByAdmin($name,$email){
        Mail::to($email)
            ->send(new sendMailChangePassByAdmin($name));
    }

    public function sendMailRegisterByAdmin($commerce,$email){
        Mail::to($email)
            ->send(new sendMailRegisterByAdmin($commerce));
    }
}
