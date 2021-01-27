<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(){
        try{
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->first();

            if($finduser){
                Auth::login($finduser);

                return redirect()->intended('welcome');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('fbHoward')
                ]);
                Auth::login($newUser);
                return redirect()->intended('welcome');
            }
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
