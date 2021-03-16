<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        $result = User::find($id);
        return $result;
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
        $request = $request->all();
        $user = new User();
        $user =  $user->find($id);
        foreach ($request as $key => $item) {
            $a =  $key;
            switch ($key) {
                case 'name':
                    $user->name = $request[$key];
                    break;
                case 'gender':
                    $user->gender = $request[$key];
                    break;
                case 'phone_number':
                    $user->phone_number = $request[$key];
                    break;
                case 'birth':
                    $user->birth = $request[$key];
                    break;
                default:
                    # code...
                    break;
            }
        }
        $result = $user->save();
        return $result;
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
}
