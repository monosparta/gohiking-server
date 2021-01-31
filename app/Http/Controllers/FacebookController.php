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
            $findUser = User::where('email', $user->email)->first();
            
            if($findUser->facebook_id){ // 帳號已經綁定FB
                Auth::login($findUser);

                $token = $findUser->user()->createToken('LaravelAuthApp')->accessToken;                
                return response()->json(['token' => $token], 200);
                // return redirect('dashboard')->with('message', 'Logged in!'); // API不需要前端頁面
            }
            if($findUser && $findUser->facebook_id == NULL ){ // 帳號已經註冊，但未綁定FB
                $updateUser = User::where('email', $user->email)->update([
                    'facebook_id' => $user->id 
                ]); 
                if (!$updateUser){
                    return response()->json(['message' => 'You can not loggin'], 401);
                    // return redirect('welcome')->with('message', 'You can not loggin');
                }
                $token = $findUser->user()->createToken('LaravelAuthApp')->accessToken;     
                return response()->json(['token' => $token], 200);
                // return redirect('dashboard')->with('message', 'Logged in!');
            }
            
            if(!$findUser){ // 帳號尚未註冊
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'password' => encrypt('fbHoward') // 不安全的寫法？
                ]);
                $newUser->save();
                Auth::login($newUser);
                $token = $newUser->createToken('LaravelAuthApp')->accessToken; 
                return response()->json(['token' => $token], 200);
                // return redirect('dashboard')->with('message', 'Logged in!');
            }              
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
