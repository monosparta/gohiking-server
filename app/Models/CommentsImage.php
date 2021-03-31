<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsImage extends Model
{
    use HasFactory;
    protected $table = 'comments_images';
    protected $primaryKey = 'id';
    protected $fillable = ['comment_id','user_id','s3_filePath','tag_id'];
    protected $hidden =['id','s3_filePath'];

    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function tag(){
        return $this->belongsTo(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
