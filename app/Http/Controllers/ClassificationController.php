<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Favorite;
use Illuminate\Http\Request;

class ClassificationController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
    public function show($id,Request $request)
    {
        $classifications = Classification::with('trails', 'trails.location', 'trails.location.county')->find($id);
        $userTrail=Favorite::select('trail_id')->where('user_id','=',$request->uuid)->get();
        for($i=0;$i<count($classifications->trails);$i++)
        {
            $classifications->trails[$i]["favorite"]=false;
            for($j=0;$j<count($userTrail);$j++)
            {
                if($classifications->trails[$i]->id===$userTrail[$j]->trail_id)
                {
                    $classifications->trails[$i]["favorite"]=true;
                }
            }
        }
        return $classifications;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
