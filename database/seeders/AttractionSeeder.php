<?php

namespace Database\Seeders;

use App\Models\Attraction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class AttractionSeeder extends Seeder
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

        foreach($json[0]['attraction'] as $data)
        {
            foreach($data['data'] as $datadata)
            {
                $newAttraction = new Attraction();
                $newAttraction->trail_id=1;
                $newAttraction->category=$data['category'];
                $newAttraction->title=$datadata['title'];
                $newAttraction->link=$datadata['link'];
                $newAttraction->save();
            }
        }
    }
}
