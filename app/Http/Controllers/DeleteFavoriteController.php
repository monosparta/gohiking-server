<?php

namespace App\Http\Controllers;

use App\Models\UserTrail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DeleteFavoriteController extends Controller
{
    public function delete(Request $request)
    {
        //
        $trails = DB::table('user_trails')->where('user_id','=',$request->user_id)->where('trail_id','=',$request->trail_id)->get();
        if(count($trails)==0)
        {
            return 'not exist';
        }
        else
        {
            $trail = DB::table('user_trails')->where('user_id','=',$request->user_id)->where('trail_id','=',$request->trail_id)->pluck('id');
            UserTrail::destroy($trail);
        }
    }   
}
