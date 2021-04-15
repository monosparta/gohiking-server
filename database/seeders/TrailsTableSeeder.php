<?php

namespace Database\Seeders;

use App\Models\County;
use App\Models\Location;
use App\Models\Trail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class TrailsTableSeeder extends Seeder
{
    public function autoIncrementTweak($id)
    {
    // $range = 4; // 根據ClearDB設定
    // return $id * 10 - 10 + $range;

    return $id; // 本機設定
    }
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
            $trail->latitude = $this->randomFloat(22, 25);
            $trail->longitude =  $this->randomFloat(120, 122);
            $trail->distance = $data['mileage'];
            $trail->coverImage = $data['imgUrl'];
            $trail->altitude = $data['mileage'] * 1000;
            $trail->difficulty = rand(1, 5);
            $trail->evaluation = rand(1, 5);
            $county_id = County::where('name', $data['city'])->get('id')[0]->id;
            $trail->location_id = Location::where('name', $data['location'])->where('county_id', $county_id)->get('id')[0]->id;
            $trail->article_id = $this->autoIncrementTweak(rand(1, 10));
            $trail->classification_id = $this->autoIncrementTweak(rand(1, 7));
            $trail->class='國家級';
            $trail->costTime=170;
            $trail->roadstatus='土石路、碎石路、棧橋、階梯';
            $trail->intro='翠峰湖環山步道環繞著台灣最大的高山湖泊，循著昔日運材軌道路線整建而成，提供春浴新綠、夏洗雨霧、秋賞紅葉、冬觀白雪的四季體驗。翠峰湖海拔1840公尺，雨季時湖面達25公頃，為台灣最大的高山湖泊，晨昏變化萬千，四季風情各異。';
            $trail->map=$data['imgUrl'];
            $trail->album=$data['imgUrl'];
          
            $trail->save();
        }
    }

    public function randomFloat($min = 0, $max = 1)
    {
        $num =  $min + mt_rand() / mt_getrandmax() * ($max - $min);
        return sprintf("%.5f", $num);
    }
}
