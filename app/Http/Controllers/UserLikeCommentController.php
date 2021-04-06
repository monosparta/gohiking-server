<?php

namespace App\Http\Controllers;

use App\Models\UserLikeComment;
use Illuminate\Http\Request;

class UserLikeCommentController extends Controller
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
        $this->validate($request, [
            'comment_id' => 'required',
            'user_id' => 'required',
            'status'=>'required|in:1,-1',
        ]);
        $userlikecomment=UserLikeComment::select('id','comment_id','user_id','status')
        ->where('comment_id','=',$request->comment_id)
        ->where('user_id','=',$request->user_id)
        ->get();
        //如果不存在這筆紀錄
        if(count($userlikecomment)===0){
            //新增一筆
            $adduserlikecomment=new UserLikeComment();
            $adduserlikecomment->comment_id=$request->comment_id;
            $adduserlikecomment->user_id=$request->user_id;
            $adduserlikecomment->status=$request->status;
            $adduserlikecomment->save();
            return 'like comment';
        }elseif($userlikecomment[0]->status!=$request->status){
            $updateuserlikecomment=UserLikeComment::find($userlikecomment[0]->id);
            $updateuserlikecomment->status=$request->status;
            $updateuserlikecomment->save();
            return 'change status';
        }elseif($userlikecomment[0]->status==$request->status){
            //有的話就移除
            UserLikeComment::destroy($userlikecomment[0]->id);
            return 'delete like comment';
        }else{
            return "你遇到BUG了，麻煩請請寄信給gohiking.app";
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
