<?php

namespace App\Http\Controllers\AuthCon;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    private $User;

    public function __construct(User $user)
    {
        $this->User         =   $user;
    }

    public function getAuth()
    {
        if(Auth::check()){
            return Auth::user();
        }else{
            return 0;
        }
    }

    public function postRegister(Request $request)
    {
        return $request->all();
    }

    public function authenticateEmail($email, Request $request)
    {
        $user = $this->User->where('email', $email)->first();

        if(isset($user)){
            //dd($request->code);
            if($user->verification_token == $request->code){
                $user->verified = 1;
                $user->verification_token = NULL;
                $user->save();

                return response()->json(['message'=>'Great! You have been activated! Now you can login with your credentials!', 'status'=> 1]);
            }else{
                if($user->verified == 1){
                    return response()->json(['message'=>'The user has already been verified! You can login now!', 'status'=>2]);
                }
                return response()->json(['message'=>'The Code that you have entered is not matching with the one in the database!', 'status'=>3]);
            }

        }else{
            return response()->json(['message'=>'I think you should check your eyes! Everything is wrong with this particular user!', 'status'=>4]);
        }
    }
}
