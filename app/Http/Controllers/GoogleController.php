<?php

namespace App\Http\Controllers;

use Exception;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            // print_r($user); // 取得可讀取的資料種類
            $findUser = User::where('email', $user->email)
            ->orWhere( 'google_id', $user->id)
            ->first();

            if (isset($findUser->google_id)) {
                Auth::login($findUser);

                $token = $findUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
            }

            if ($findUser && $findUser->google_id == NULL) {
                $updateUser = User::where('email', $user->email)->update([
                    'google_id' => $user->id
                ]);
                if (!$updateUser) {
                    return response()->json(['message' => 'You can not loggin'], 401);
                }
                $token = $findUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
            }

            if (!$findUser) {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => bcrypt($user->token),
                    'image' => $user->avatar,
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
