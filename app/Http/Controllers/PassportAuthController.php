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
            // 'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $findUser = User::where('email', $request->email)->first();

        if($findUser) {
            return response()->json(['token' => 'This email is already registered!'], 404);
        } else {
            $user = User::create([
            // 'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
       
        // 預先產生與回傳前端存取需驗證身分的API時，於headers攜帶的token，即可註冊後直接登入使用
        $token = $user->createToken('LaravelAuthApp')->accessToken; 
        return response()->json(['token' => $token], 200);
        }
 
        
    }

    public function createProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'birth' => 'required',
            'live' => 'required',
        ]);

        $findUser = User::where('id', $request->user()->id)->first();

        if($findUser){ // 帳號剛註冊，須建立個人資料
                $updateUser = User::where('email', $findUser->email)->update([
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'phone_number' => $request->phoneNumber,
                    'birth' => $request->birth,
                    'live' => $request->live,
                ]); 
                
                return response()->json(['Status' => 'Your profile is created!'], 200);
        } else {
            return response()->json(['error' => 'This account is missing!'], 401);
        }
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