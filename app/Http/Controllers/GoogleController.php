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
            $finduser = User::where('email', $user->email)->first();
            
            if($finduser->google_id){
                Auth::login($finduser);

                return redirect('dashboard')->with('message', 'Logged in!');
            }
            if($finduser && $finduser->google_id == NULL ){
                $updateUser = User::where('email', $user->email)->update([
                    'google_id' => $user->id 
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
                    'google_id' => $user->id,
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
