<?php

namespace App\Http\Controllers;

use App\Models\UserTrail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trails = DB::table('user_trails')->select('user_id', 'trail_id')->get()->groupBy('user_id');
        return $trails;
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
        $this->validate($request, [
            'user_id' => 'required',
            'trail_id' => 'required',
        ]);
        $trails = DB::table('user_trails')->where('user_id','=',$request->user_id)->where('trail_id','=',$request->trail_id)->get();
        if(count($trails)==0)
        {
            $UserTrail= new UserTrail;
            $UserTrail->user_id= $request->user_id;
            $UserTrail->trail_id=$request->trail_id;
            $UserTrail->save();
        }
        else
        {
            return 'exist data';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //sql SELECT trail_id FROM `user_trails` WHERE user_id=$id
        $trails = DB::table('user_trails')->where('user_id', $id)->leftJoin('trails', 'user_trails.trail_id', '=', 'trails.id')->get();
        return $trails;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //nothing
    }
}
