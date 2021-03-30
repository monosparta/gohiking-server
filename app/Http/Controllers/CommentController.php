<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Models\CommentsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), $this->rule(), $this->errorMassage());
        if ($validator->fails()) {
            $error = "";
            $errors = $validator->errors();
            foreach ($errors->all() as $message)
                $error .= $message . "\n";
            return ['status' => 0, 'massage' => $error];
        }

        $comments=new Comment();
        $comments->user_id=$request->user_id;
        $comments->trail_id=$request->trail_id;
        $comments->date=$request->date;
        $comments->star=$request->star;
        $comments->difficulty=$request->difficulty;
        $comments->beauty=$request->beauty;
        $comments->duration=$request->duration;
        $comments->content=$request->content;
        $comments->likes=0;
        $comments->dislikes=0;
        $comments->save();//新增
        //取的最新一筆 該使用者新增的comment_id
        $last_comments_id=Comment::select('id')->where('user_id','=',$request->user_id)->latest('id')->first();
        if(isset($request->s3_url)&&isset($request->tag_id)){
            $s3_urls=explode(',',$request->s3_url);//多筆請用,分割
            $tags=explode(',',$request->tag_id);//分割傳來圖片的tag數字
            for($i=0;$i<count($s3_urls);$i++)//看有幾筆，就新增幾筆
            {
                $commentsImages=new CommentsImage();
                $commentsImages->comment_id=$last_comments_id->id;
                $commentsImages->user_id=$request->user_id;
                $commentsImages->s3_url=$s3_urls[$i];
                $commentsImages->tag_id=$tags[$i];
                $commentsImages->save();
            }
        }

        return Comment::with('commentsImages.tag')->where('trail_id','=',$request->trail_id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $totalPeople=count(Comment::select('star') ->where('trail_id','=',$id)->get());
        $avgStar=Comment::select('star') ->where('trail_id','=',$id)->avg('star');
        $stars=Comment::select('star',DB::raw('count(*) as count'))
        ->where('trail_id','=',$id)
        ->groupBy('star')
        ->get();
        $starsgrop[0][0]="one";
        $starsgrop[1][0]="two";
        $starsgrop[2][0]="three";
        $starsgrop[3][0]="four";
        $starsgrop[4][0]="five";
        $comments=Comment::with('commentsImages')->where('trail_id','=',$id)->get();
        // for($i=0;$i<count($comments))
        return response()->json(array(
            'totalPeople'=>$totalPeople,
            'avgStar'=>$avgStar,
            'stars'=>$stars,
            'comments'=>$comments,
        ));
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

    private function rule()
    {
        return
            [
                'user_id'=>'bail|required',
                'trail_id'=>'bail|required',
                'date'=>'bail|required',
                'star'=>'bail|required',
                'difficulty'=>'bail|required',
                'beauty'=>'bail|required',
                'duration'=>'bail|required',
                'content'=>'bail|required',
            ];
    }

    private function errorMassage()
    {
        return
            [
                'user_id.required' => '使用者_id必填',
                'trail_id.required' => '步道_id必填',
                'date.required' => '日期必填',
                'star.required' => '星級必填',
                'difficulty.required' => '難易度必填',
                'beauty.required' => '景色必填',
                'duration.required' => '耗時必填',
                'content.required' => '評論必填',
            ];
    }
}
