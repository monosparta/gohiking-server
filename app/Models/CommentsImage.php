<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsImage extends Model
{
    use HasFactory;
    protected $table = 'comments_images';
    protected $primaryKey = 'id';
    protected $fillable = ['comment_id','user_id','s3_url','tag_id'];
}
