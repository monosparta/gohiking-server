<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $table ='collections';
    protected $primaryKey ='id';
    protected $fillable =['name','subTitle','iconImage'];

    public function trails(){
        return $this->belongsToMany('App\Models\Trail','collection_trail','collection_id','trail_id');
    }
}
