<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'county_id'];

    public function location()
    {
        return $this->hasOne('App\Models\County');
    }
    public function county()
    {
        return $this->belongsTo('App\Models\County');
    }
}
