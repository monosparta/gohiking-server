<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name' => '北投區',
                'county_id' => 1,
            ],
            [
                'name' => '復興區',
                'county_id' => 3,
            ],
            [
                'name' => '復興鄉',
                'county_id' => 3,
            ],
            [
                'name' => '北屯區',
                'county_id' => 7,
            ],
            [
                'name' => '南屯區',
                'county_id' => 7,
            ],
            [
                'name' => '新烏日',
                'county_id' => 7,
            ],
            [
                'name' => '沙鹿區',
                'county_id' => 7,
            ],
            [
                'name' => '谷關區',
                'county_id' => 7,
            ],
        ];
        foreach ($datas as $data) {
            $location = new Location();
            $location->name = $data['name'];
            $location->county_id = $data['county_id'];
            $location->save();
        }
    }
}
