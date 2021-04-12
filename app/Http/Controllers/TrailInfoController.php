<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\Attraction;
use App\Models\Trail;
use App\Models\TrailHead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommentController;
use App\Models\ChipTrail;

class TrailInfoController extends Controller
{
    protected $CommentController;
    public function __construct(CommentController $CommentController)
    {
        $this->CommentController =$CommentController;
    }
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
    public function show($id,Request $request)
    {
        $result=Trail::select('title','altitude','classification_id','distance','class','costTime','roadstatus','intro','map','trailstatus')->find($id);
        if($id==1){
            $result['trailstatus']='目前全線封閉，暫停開放。';
        }

        $location=Trail::select('location_id')->with('location.county')->first();
        $location=$location->location->name.$location->location->county->name;
        $result['location']=$location;

        $chips=ChipTrail::select('chip_id')->where('trail_id','=',$id)->with('chip')->get();
        $chipArray=[];
        foreach($chips as $chip)
        {
            array_push($chipArray,$chip->chip->name);
        }
        $result['chips']=$chipArray;

        $trailHead=TrailHead::select('name','latitude','longitude','bannerImage','description')->where('trail_id','=',$id)->get();
        $bannerImage=array();
        foreach ($trailHead as $key => $value) {
            $bannerImage=explode(',',$value->bannerImage);
            $value['bannerImage']=$bannerImage;
        }
        $result['trailHead']=$trailHead;
        

        $result['chart']=[5,3,2,1,5];


        $album=Trail::select('album')->find($id)->album;
        $albums=explode(',',$album);
        $result['album']=$albums;

        $announcement=Announcement::select('imgUrl','title','date','source','link')->where('trail_id',$id)->get();
        $result['announcement']=$announcement;

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
        $result['attraction']=$attractions;

        $comment=$this->CommentController->show($id,$request)->original;
        $result['comment']=$comment;

        $articles = Article::select('id','title','image','updated_at')->take(5)->get();
        $result['articles']=$articles;

        $similar=Trail::select('title','coverImage','distance','location_id')->with('location.county')->where('classification_id',$result->classification_id)->get();
        $result['similar']=$similar;

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
