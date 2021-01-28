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
            $finduser = User::where('email', $user->email)->first();
            
            if($finduser->facebook_id){
                Auth::login($finduser);

                return redirect('dashboard')->with('message', 'Logged in!');
            }
            if($finduser && $finduser->facebook_id == NULL ){
                $updateUser = User::where('email', $user->email)->update([
                    'facebook_id' => $user->id 
                ]); 
                if (!$updateUser){
                    return redirect('welcome')->with('message', 'You can not loggin');
                }
                return redirect('dashboard')->with('message', 'Logged in!');
            }
            
            if(!$finduser){
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'password' => encrypt('fbHoward')
                ]);
                $newUser->save();
                Auth::login($newUser);
                return redirect('dashboard')->with('message', 'Logged in!');
            }              
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
