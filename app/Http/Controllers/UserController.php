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
        $user = User::with('county')->find($id);
        return  $user;
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
        $user = User::find($id);
        foreach ($request as $key => $item) {
            switch ($key) {
                case 'name':
                    $user->name = $item;
                    break;
                case 'gender':
                    $user->gender = $item;
                    break;
                case 'phone_number':
                    $user->phone_number = $item;
                    break;
                case 'birth':
                    $user->birth = $item;
                    break;
                case 'image':
                    $user->image = $item;
                    break;
                case 'county_id':
                    $user->county_id = $item;
                    break;
                default:
                    # code...
                    break;
            }
        }
        $user->save();
        $user = User::with('county')->find($id);
        return $user;
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
