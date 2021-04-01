<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Models\CommentsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

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
        // //驗證資料
        $validator = Validator::make($request->all(), $this->rule(), $this->errorMassage());
        if ($validator->fails()) {
            $error = "";
            $errors = $validator->errors();
            foreach ($errors->all() as $message)
                $error .= $message . "\n";
            return ['status' => 0, 'massage' => $error];
        }
        //新增評論
        $comments=new Comment();
        $comments->user_id=$request->user_id;
        $comments->trail_id=$request->trail_id;
        $comments->date=$request->date;
        $comments->star=$request->star;
        $comments->difficulty=$request->difficulty;
        $comments->beauty=$request->beauty;
        $comments->duration=$request->duration;
        $comments->content=$request->content;
        $comments->save();//新增
        //取的最新一筆 該使用者新增的comment_id
        $last_comments_id=Comment::select('id')->where('user_id','=',$request->user_id)->latest('id')->first();
        //評論圖片如果有上傳，才執行
        if(isset($request->images) && isset($request->tag_id)){
            if($this->upload_s3($request->images)){
                $s3_filePaths=$this->upload_s3($request->images);
            }
            else{
                $s3_filePaths='';
            }
            $tags=explode(',',$request->tag_id);//分割傳來圖片的tag數字
            for($i=0;$i<count($tags);$i++)//看有幾筆，就新增幾筆
            {
                $commentsImages=new CommentsImage();
                $commentsImages->comment_id=$last_comments_id->id;
                $commentsImages->user_id=$request->user_id;
                $commentsImages->s3_filePath=$s3_filePaths[$i];//放置S3URL
                $commentsImages->tag_id=$tags[$i];
                $commentsImages->save();
            }
        }

        return Comment::with('commentsImages.tag')->where('trail_id','=',$request->trail_id)->get();
     Storage::disk('s3')->exists('1.jpg');
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
        //starts 取的資料是統計資料庫的 count數字1~5 不方便前端存取
        //startsgroup 回傳 前端方便存取的格式
        $starsgroup=[
            "one"=>"0",
            "two"=>"0",
            "three"=>"0",
            "four"=>"0",
            "five"=>"0"
        ];
        //判斷 $stars的星級是哪一個，再塞入 starsgroup $stars人數
        foreach($stars as $key=>$value)
        {
            switch ($value->star){
                case 1:
                    $starsgroup['one']=$value->count;
                    break;
                case 2:
                    $starsgroup['two']=$value->count;
                    break;
                case 3:
                    $starsgroup['three']=$value->count;
                    break;
                case 4:
                    $starsgroup['four']=$value->count;
                    break;
                case 5:
                    $starsgroup['five']=$value->count;
                    break;
            }
        }
        //取的目前的comment data
        $comments=Comment::with('user:id,name','commentsImages:id,comment_id,s3_filePath,tag_id')
        ->where('trail_id','=',$id)
        ->withCount(['userLikeComment as like'=>function(Builder $likequery){
            $likequery->where('status',1);//1 = like count 算出status等於1的有多少
        },'userLikeComment as dislike'=>function(Builder $dislikequery){
            $dislikequery->where('status',-1);//-1 = dislike count 算出status等於-1的有多少
        }
        ])->get();
        foreach($comments as $key=>$values)
        {
            foreach($comments[$key]['commentsImages'] as $value)
            {
                //取得圖片URL
                $value['s3_url']=$this->getFileUrl_s3($value->s3_filePath);
            }
        }

        return response()->json(array(
            'totalPeople'=>$totalPeople,//評論總人數
            'avgStar'=>$avgStar,//平均星數
            'stars'=>$starsgroup,//各星級人數
            'comments'=>$comments,//評論內容
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
                'date'=>'bail|required|date:' . date("Y-m-d"),
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

    private function upload_s3($uploadImage)
    {
        $date = new DateTime();
        $timestamp =  $date->getTimestamp();
        list($baseType, $image) = explode(';', $uploadImage);
        list(, $image) = explode(',', $image);
        $image = base64_decode($image);
        $filePath = 'imgs/' . $timestamp . '.jpg';
        return Storage::disk('s3')->put($filePath, $image) ? $filePath : false;
    }

    private function getFileUrl_s3($fileName)
    {
        $client = Storage::disk('s3')->getDriver()->getAdapter()->getClient();
        $command = $client->getCommand('GetObject', [
            'Bucket' => 'monosparta-test',
            'Key' => $fileName
        ]);
        $request = $client->createPresignedRequest($command, '+7 days');
        $presignedUrl = (string)$request->getUri();
        return $presignedUrl;
    }
}
