<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try{
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){
                Auth::login($finduser);

                return redirect()->intended('/')->with('message', 'Logged in!');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('googleHoward')
                ]);
                Auth::login($newUser);
                return redirect()->intended('/')->with('message', 'Logged in!');
            }
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
