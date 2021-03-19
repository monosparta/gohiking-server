<?php

namespace App\Http\Controllers;

use Exception;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $findUser = User::where('email', $user->email)
            ->orWhere('facebook_id', $user->id)
            ->first();
            
            if (isset($findUser->facebook_id)) { // 帳號已經綁定FB，用isset()避免出現"Trying to get property facebook_id of non-object"的錯誤
                Auth::login($findUser);

                $token = $findUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
            }

            if ($findUser && $findUser->facebook_id == NULL) { // 帳號已經註冊，但未綁定FB
                $updateUser = User::where('email', $user->email)->update([
                    'facebook_id' => $user->id
                ]);
                if (!$updateUser) {
                    return response()->json(['message' => 'You can not loggin'], 401);
                }
                $token = $findUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
            }

            if (!$findUser) { // 帳號尚未註冊
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'password' => bcrypt($user->token)
                ]);
                $newUser->save();
                Auth::login($newUser);
                $token = $newUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
