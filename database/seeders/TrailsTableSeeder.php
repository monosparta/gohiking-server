<?php

namespace Database\Seeders;

use App\Models\County;
use App\Models\Location;
use App\Models\Trail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class TrailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = FacadesStorage::disk('local')->get('trails.json');
        $json = json_decode($json, true);

        foreach ($json as $data) {
            $trail = new Trail();
            $trail->title = $data['title'];
            $trail->distance = $data['mileage'];
            $trail->coverImage = $data['imgUrl'];
            $trail->altitude = $data['mileage'];
            $trail->difficulty = rand(1, 10);
            $trail->evaluation = rand(1, 10);
            $county_id = County::where('name', $data['city'])->get('id')[0]->id;
            $trail->location_id = Location::where('name', $data['location'])->where('county_id', $county_id)->get('id')[0]->id;
            $trail->article_id = rand(1, 10);
            $trail->classification_id = rand(1, 10);
            $trail->save();
        }
    }
}
