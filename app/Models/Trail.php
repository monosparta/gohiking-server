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
}
