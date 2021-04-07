<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChipTrail extends Model
{
    use HasFactory;

    public function chip()
    {
        return $this->belongsTo(Chip::class);
    }
}
