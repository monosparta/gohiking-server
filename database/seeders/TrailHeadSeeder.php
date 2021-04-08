<?php

namespace Database\Seeders;

use App\Models\TrailHead;
use Illuminate\Database\Seeder;
use App\Models\Trail;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class TrailHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = FacadesStorage::disk('local')->get('pathwayinfo.json');
        $json = json_decode($json, true);

        $counttrail=count(Trail::select('id')->get());
        for($i=1;$i<=$counttrail;$i++)
        {
            foreach($json[0]['trailhead'] as $data)
            {
                $newTrailHead=new TrailHead();
                $newTrailHead->trail_id=$i;
                $newTrailHead->name=$data['name'];
                $newTrailHead->latitude=$data['coordinate'][0];
                $newTrailHead->longitude=$data['coordinate'][1];
                $newTrailHead->bannerImage=implode(",",$data['bannerImg']);
                $newTrailHead->description=$data['description'];
                $newTrailHead->save();
            }
        }
    }
}
