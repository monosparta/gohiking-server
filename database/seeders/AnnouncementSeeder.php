<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Trail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class AnnouncementSeeder extends Seeder
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
            foreach($json[0]['announcement'] as $data)
            {
                $newAnnouncement = new Announcement();
                $newAnnouncement->trail_id= $i;
                $newAnnouncement->title=$data['title'];
                $newAnnouncement->imgUrl=$data['img'];
                $newAnnouncement->date=$data['date'];
                $newAnnouncement->source=$data['source'];
                $newAnnouncement->link=$data['link'];
                $newAnnouncement->save();
            }
        }
    }
}
