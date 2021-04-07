<?php

namespace Database\Seeders;

use App\Models\ChipTrail;
use Illuminate\Database\Seeder;

class ChipTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=8;$i++)
        {
            $newChipTrail= new ChipTrail();
            $newChipTrail->chip_id=$i;
            $newChipTrail->trail_id=1;
            $newChipTrail->save();
        }
        
    }
}
