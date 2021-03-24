<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Favorite;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Collection::get();
        return $result;
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
    public function show($id,Request $request)
    {
        $result=Collection::with('trails')->find($id);
        $userTrail=Favorite::select('trail_id')->where('user_id','=',$request->uuid)->get();
        for($i=0;$i<count($result->trails);$i++)
        {
            $result->trails[$i]["favorite"]=false;
            for($j=0;$j<count($userTrail);$j++)
            {
                if($result->trails[$i]->id===$userTrail[$j]->trail_id)
                {
                    $result->trails[$i]["favorite"]=true;
                }
            }
        }
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
        //
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
