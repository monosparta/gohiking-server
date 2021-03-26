<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = FacadesStorage::disk('local')->get('tags.json');
        $json = json_decode($json, true);
        foreach($json as $data){
            $tag=new Tag();
            $tag->tagName=$data['tagName'];
        }
    }
}
