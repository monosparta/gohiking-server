<?php

namespace Database\Seeders;

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
        DB::table('locations')->delete();
        $datas=[
            [
                'name'=>'北投區',
                'county_id'=>1,
            ],
            [
                'name'=>'復興區',
                'county_id'=>21,
            ],
            [
                'name'=>'復興鄉',
                'county_id'=>21,
            ],
            [
                'name'=>'北屯區',
                'county_id'=>61,
            ],
            [
                'name'=>'南屯區',
                'county_id'=>61,
            ],
            [
                'name'=>'新烏日',
                'county_id'=>61,
            ],
            [
                'name'=>'沙鹿區',
                'county_id'=>61,
            ],
            [
                'name'=>'谷關區',
                'county_id'=>61,
            ],
        ];
        foreach ($datas as $data){
            DB::table('locations')->insert([
                'name' => $data['name'],
                'county_id' => $data['county_id'],
                ]);
        }
    }
}
