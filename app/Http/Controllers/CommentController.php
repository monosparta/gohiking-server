<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        $totalPeople=count(Comment::select('star') ->where('trail_id','=',$request->trail_id)->get());
        $avgStar=Comment::select('star') ->where('trail_id','=',$request->trail_id)->avg('star');
        $stars=Comment::select('star',DB::raw('count(*) as count'))
        ->where('trail_id','=',$request->trail_id)
        ->groupBy('star')
        ->get();
        $comments=Comment::with('commentsImages')->where('trail_id','=',$request->trail_id)->get();
        // for($i=0;$i<count($comments))
        return response()->json(array(
            'totalPeople'=>$totalPeople,
            'avgStar'=>$avgStar,
            'stars'=>$stars,
            'comments'=>$comments,
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
