<?php
// 參考：https://www.positronx.io/laravel-rest-api-with-passport-authentication-tutorial/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Mail;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    { // 對帳密等資料的長短限制可再討論
        $this->validate($request, [
            'email' => 'required|email',
            // 'password' => 'required|min:8', // 加上長度限制的寫法
            'password' => 'required',
        ]);

        $findUser = User::where('email', $request->email)->first();

        if ($findUser) {
            return response()->json(['error' => 'this email is already registered!'], 404);
        } else {
            $user = User::create([
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
            'phone_region' => 'required',
            'birth' => 'required',
            'live' => 'required',
        ]);

        $findUser = User::where('id', $request->user()->id)->first();

        if ($findUser) { // 帳號剛註冊，須建立個人資料
            User::where('email', $findUser->email)->update([
                'name' => $request->name,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'phone_region' => $request->phone_region,
                'birth' => $request->birth,
                'live' => $request->live,
            ]);
            return response()->json(['status' => 'your profile is created!'], 200);
        } else {
            return response()->json(['error' => 'this account is missing!'], 401);
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
            return response()->json(['error' => 'wrong email or password!'], 401);
        }
    }

    public function forgetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);

        $findUser = User::where('email', $request->email)->first();

        if ($findUser) {
            // 產生驗證碼
            function randomCode()
            {
                return rand(0, 9);
            }

            $verificationCodes = [randomCode(), randomCode(), randomCode(), randomCode()];
            error_log($verificationCodes[0] . ', ' . $verificationCodes[1] . ', ' . $verificationCodes[2] . ', ' . $verificationCodes[3]);

            // 寄送驗證碼信件，參考：https://ithelp.ithome.com.tw/articles/10252073
            $email = $request->email;
            $userToken = $findUser->remember_token;
            $url = env('APP_URL')."/api/password/change/$userToken";
            $text = '你的驗證碼是：' . $verificationCodes[0] . ', ' . $verificationCodes[1] . ', ' . $verificationCodes[2] . ', ' . $verificationCodes[3] . '，若要更改密碼，請點以下連結繼續：' . $url;

            // 將驗證碼寫入資料庫的使用者表格，以便在驗證時對應
            User::where('email', $findUser->email)->update([
                'verification_code_0' => $verificationCodes[0],
                'verification_code_1' => $verificationCodes[1],
                'verification_code_2' => $verificationCodes[2],
                'verification_code_3' => $verificationCodes[3],
            ]);

            try {
                Mail::raw($text, function ($message) use ($email) {
                    $message->to($email)->subject('請確認修改密碼');
                });
                error_log('Successfully send to ' . $email);
            } catch (Exception $e) {
                error_log('fail!');
            }
        }
        return response()->json(['message' => '已寄送驗證碼到指定信件！'])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    public function confirmVerificationCodes(Request $request)
    {
        $this->validate($request, [
            'verificationCode0' => 'required',
            'verificationCode1' => 'required',
            'verificationCode2' => 'required',
            'verificationCode3' => 'required',
        ]);

        $findUser = User::where('verification_code_0', $request->verificationCode0)->where('verification_code_1', $request->verificationCode1)->where('verification_code_2', $request->verificationCode2)->where('verification_code_3', $request->verificationCode3)->first();

        if ($findUser) {
            $token = $findUser->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'wrong verification codes!'], 401);
        }
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
        ]);

        try {
            User::where('id', $request->user()->id)->first()->update([
                'password' => bcrypt($request->password)
            ]);
            return response()->json(['status' => 'your password has been changed!'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'this account is missing!'], 401);
        }
    }
}
