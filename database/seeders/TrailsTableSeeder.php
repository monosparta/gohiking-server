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
            $trail->latitude = $this->randomFloat(10, 1000);
            $trail->longitude =  $this->randomFloat(10, 1000);
            $trail->distance = $data['mileage'];
            $trail->coverImage = $data['imgUrl'];
            $trail->altitude = $data['mileage'] * 1000;
            $trail->difficulty = rand(1, 5);
            $trail->evaluation = rand(1, 5);
            $county_id = County::where('name', $data['city'])->get('id')[0]->id;
            $trail->location_id = Location::where('name', $data['location'])->where('county_id', $county_id)->get('id')[0]->id;
            $trail->article_id = rand(1, 10);
            $trail->classification_id = rand(1, 7);
            $trail->save();
        }
    }

    public function randomFloat($min = 0, $max = 1)
    {
        $num =  $min + mt_rand() / mt_getrandmax() * ($max - $min);
        return sprintf("%.5f", $num);
    }
}
