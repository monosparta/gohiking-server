<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trail extends Model
{
    use HasFactory;
    protected $table = 'trails';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'location_id', 'distance', 'coverImage', 'difficulty', 'evaluation', 'altitude'];

    public function collections()
    {
        return $this->belongsToMany('App\Models\Collection','collection_trail','trail_id','collection_id');
    }
}
