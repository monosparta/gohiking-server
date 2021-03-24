<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\CountryCode;
use App\Models\County;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('county')->find($id);
        $countrycodes = CountryCode::all();

        return  ['users' => $user, 'countrycodes' => $countrycodes];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rule(), $this->errorMassage());
        if ($validator->fails()) {
            $error = "";
            $errors = $validator->errors();
            foreach ($errors->all() as $message)
                $error .= $message . "\n";
            return ['status' => 0, 'massage' => $error];
        }
        $isSuccess = $this->userUpdate($request, $id);
        return $isSuccess ? ['status' => 200, 'massage' => "新增成功"] : ['status' => 0, 'massage' => "新增失敗，查無縣市"];
    }

    private function userUpdate($request, $id)
    {
        $user = User::find($id);
        foreach ($request->all() as $key => $item) {
            switch ($key) {
                case 'name':
                    $user[$key] = $item;
                    break;
                case 'gender':
                    $user[$key] = $item;
                    break;
                case 'country_code_id':
                    $user[$key] = $item;
                    break;
                case 'phone_number':
                    $user[$key] = $item;
                    break;
                case 'birth':
                    $user[$key] = $item;
                    break;
                case 'image':
                    $user[$key] = $item;
                    break;
                case 'county':
                    $checkCountyId = County::where('name', $item)->get('id');
                    if (count($checkCountyId))
                        $user->county_id = $checkCountyId[0]->id;
                    else
                        return $user = 0;
                    break;
                default:
                    # code...
                    break;
            }
        }
        return $user->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function rule()
    {
        return
            [
                'name' => 'bail|required|max:10',
                'gender' => 'bail|required|in:0,1',
                'phone_number' => 'bail|required',
                'birth' => 'bail|required|date|before:' . date("Y/m/d"),
                'image' => 'bail|required|max:1024',
                'county' => 'bail|required|max:3|min:3'
            ];
    }

    private function errorMassage()
    {
        return
            [
                'name.required' => '名字必填',
                'name.max' => '名字最多:max個字',
                'gender.required' => '性別必填',
                'gender.in' => '性別只能為男或女',
                'phone_number' => '手機必填',
                'birth.required' => '生日必填',
                'birth.date' => '生日格式錯誤',
                'birth.before' => '生日時間不能大於:date',
                'image.required' => '圖片必填',
                'image.max' => '圖片不能超過:maxKB',
                'county.required' => '居住地必填',
                'county.max' => '居住地最多:max個字',
                'county.min' => '居住地最少:min個字',
            ];
    }
}
