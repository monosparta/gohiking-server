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
        return $this->belongsToMany('App\Models\Collection', 'collection_trail', 'trail_id', 'collection_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function articles()
    {
        return $this->belongsTo(Article::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'favorites','trail_id','user_id');
    }
    public function favorites(){
        return $this->hasMany(Favorite::class);
    }
}
