<?php

namespace Database\Seeders;

use App\Models\ChipTrail;
use App\Models\Trail;
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
        $counttrail=count(Trail::select('id')->get());
        for($j=1;$j<=$counttrail;$j++)
        {
            for($i=1;$i<=8;$i++)
            {
                $newChipTrail= new ChipTrail();
                $newChipTrail->chip_id=$i;
                $newChipTrail->trail_id=$j;
                $newChipTrail->save();
            }
        }
        
    }
}
