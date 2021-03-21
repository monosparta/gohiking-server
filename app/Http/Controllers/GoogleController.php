<?php

namespace App\Http\Controllers;

use Exception;
// use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class GoogleController extends Controller
{
    // public function redirectToGoogle()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    // public function handleGoogleCallback()
    public function handleGoogleCallback(Request $request)
    {
        try {
            // $user = Socialite::driver('google')->user();
            // print_r($user); // 取得可讀取的資料種類
            $findUser = User::where('email', $request->email)
            ->orWhere( 'google_id', $request->id)
            ->first();

            if (isset($findUser->google_id)) {
                Auth::login($findUser);

                $token = $findUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
            }

            if ($findUser && $findUser->google_id == NULL) {
                $updateUser = User::where('email', $request->email)->update([
                    'google_id' => $request->id
                ]);
                if (!$updateUser) {
                    return response()->json(['message' => 'You can not loggin'], 401);
                }
                $token = $findUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
            }

            if (!$findUser) {
                $newUser = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'google_id' => $request->id,
                    'password' => bcrypt($request->token),
                    'image' => $request->avatar,
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
