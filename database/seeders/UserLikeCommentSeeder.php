<?php

namespace Database\Seeders;

use App\Models\UserLikeComment;
use Illuminate\Database\Seeder;

class UserLikeCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $max=10;
        for($i=0;$i<$max;$i++){
            $likeComment=new UserLikeComment();
            $likeComment->comment_id=rand(1,10);
            $likeComment->user_id=rand(1,10);
            $likeComment->status=1;
            $likeComment->save();
        }
    }
}
