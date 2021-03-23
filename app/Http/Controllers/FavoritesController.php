<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
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
        $trails = DB::table('favorites')->select('user_id', 'trail_id')->get()->groupBy('user_id');
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
        $trails = DB::table('favorites')->where('user_id', '=', $request->user_id)->where('trail_id', '=', $request->trail_id)->get();
        if (count($trails) == 0) {
            //如果沒有存在就新增
            $UserTrail = new Favorite;
            $UserTrail->user_id = $request->user_id;
            $UserTrail->trail_id = $request->trail_id;
            $UserTrail->save();
            return 'add favorite';
        } else {
            //如果重複就刪掉
            $trail = DB::table('favorites')->where('user_id', '=', $request->user_id)->where('trail_id', '=', $request->trail_id)->pluck('id');
            Favorite::destroy($trail);
            return 'delete favorite';
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
        $trails = DB::table('favorites')->where('user_id', $id)->leftJoin('trails', 'user_trails.trail_id', '=', 'trails.id')->get();
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
    //移除功能
    // public function delete(Request $request)
    // {
    //     //
    //     $trails = DB::table('favorites')->where('user_id', '=', $request->user_id)->where('trail_id', '=', $request->trail_id)->get();
    //     if (count($trails) == 0) {
    //         return 'not exist';
    //     } else {
    //         $trail = DB::table('favorites')->where('user_id', '=', $request->user_id)->where('trail_id', '=', $request->trail_id)->pluck('id');
    //         Favorite::destroy($trail);
    //     }
    // }
}
