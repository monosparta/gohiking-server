<?php

namespace Database\Seeders;

use App\Models\Announcement;
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
        
        foreach($json[0]['announcement'] as $data)
        {
            $newAnnouncement = new Announcement();
            $newAnnouncement->trail_id= 1;
            $newAnnouncement->title=$data['title'];
            $newAnnouncement->imgUrl=$data['img'];
            $newAnnouncement->date=$data['date'];
            $newAnnouncement->source=$data['source'];
            $newAnnouncement->link=$data['link'];
            $newAnnouncement->save();
        }
    }
}
