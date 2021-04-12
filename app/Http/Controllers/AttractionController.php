<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;

class AttractionController extends Controller
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
        $attraction=Attraction::select('category','title','link')->where('trail_id',$id)->get();
        $group = array();
        foreach ($attraction as $key => $value) {
            $group[$value['category']][] = ['title'=>$value['title'],'link'=>$value['link']];
        }
        $attractions=array();
        foreach ($group as $key => $value) {
            $attraction=['category'=>$key,'data'=>$value];
            array_push($attractions,$attraction);
        }
        return $attractions;
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
