<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
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
            $findUser = User::where('email', $user->email)->first();

            if ($findUser->google_id) {
                Auth::login($findUser);

                $token = $findUser->user()->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
                // return redirect('dashboard')->with('message', 'Logged in!'); 
            }
            if ($findUser && $findUser->google_id == NULL) {
                $updateUser = User::where('email', $user->email)->update([
                    'google_id' => $user->id
                ]);
                if (!$updateUser) {
                    return response()->json(['message' => 'You can not loggin'], 401);
                    // return redirect('welcome')->with('message', 'You can not loggin');
                }
                $token = $findUser->user()->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
                // return redirect('dashboard')->with('message', 'Logged in!'); 
            }

            if (!$findUser) {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('fbHoward') // 不安全的寫法？
                ]);
                $newUser->save();
                Auth::login($newUser);
                $token = $newUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
                // return redirect('dashboard')->with('message', 'Logged in!'); 
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
