<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','trail_id','date','star','difficulty','beauty','duration','content','likes','dislikes'];

    public function trail(){
        return $this->belongsTo(Trail::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function commentsImages(){
        return $this->hasMany(CommentsImage::class);
    }

    public function userLikeComment(){
        return $this->hasMany(UserLikeComment::class);
    }
}
