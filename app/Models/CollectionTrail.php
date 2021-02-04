<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionTrail extends Model
{
    use HasFactory;
    protected $table ='collection_trail';
    protected $primaryKey ='id';
    protected $fillable =['collection_id','trail_id'];
}
