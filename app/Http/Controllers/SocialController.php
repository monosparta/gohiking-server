<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function handleSocialCallback(Request $request)
    {
        try {
            $findUser = User::where('email', $request->email)
            ->first();            

            // 帳號已經註冊，用isset()避免出現"Trying to get property facebook_id of non-object"的錯誤
            if (isset($findUser->email)) {

                 // 帳號未綁定特定社群帳號
                if ($findUser->facebook_id === NULL) 
                {
                    User::where('email', $request->email)->update([
                        'facebook_id' => $request->facebook_id,
                    ]);
                }

                if ($findUser->google_id === NULL) {
                    User::where('email', $request->email)->update([
                        'google_id' => $request->google_id,
                    ]);
                }

                if ($findUser->apple_id === NULL) {
                    User::where('email', $request->email)->update([
                        'apple_id' => $request->apple_id,
                    ]);
                }

                Auth::login($findUser);

                $token = $findUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token, 'userId' => $findUser->id, 'expireTime' => 86400000], 200);
            }   

            // 帳號尚未註冊
            if (!$findUser) {
                $newUser = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'facebook_id' => $request->facebook_id,
                    'google_id' => $request->google_id,
                    'apple_id' => $request->apple_id,
                    'password' => bcrypt($request->token),
                    'image' => $request->avatar,
                ]);
                $newUser->save();
                Auth::login($newUser);
                $token = $newUser->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' =>$token, 'userId' => $newUser->id, 'expireTime' => 86400000], 200);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
