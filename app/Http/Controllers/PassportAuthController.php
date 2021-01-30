<?php
// 參考：https://www.positronx.io/laravel-rest-api-with-passport-authentication-tutorial/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    { // 對帳密等資料的長短限制可再討論
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
       
        // 預先產生與回傳前端存取需驗證身分的API時，於headers攜帶的token，即可註冊後直接登入使用
        $token = $user->createToken('LaravelAuthApp')->accessToken; 
        return response()->json(['token' => $token], 200);
    }
 
    public function login(Request $request)
    {
        $logInData = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($logInData)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Wrong email or password!'], 401);
        }
    }   
}