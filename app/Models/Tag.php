<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = ['tagName'];

    public function commentsImages(){
        return $this->hasMany(CommentsImage::class);
    }
}
