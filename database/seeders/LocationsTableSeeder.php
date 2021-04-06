<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = FacadesStorage::disk('local')->get('taiwan_districts.json');
        $json = json_decode($json, true);

        foreach ($json as $key => $data) {
            foreach ($data['districts'] as $value) {
                $location = new Location();
                $location->zip = $value['zip'];
                $location->name = $value['name'];
                $location->county_id = autoIncrementTweak($key + 1);
                $location->save();
            }
        }
    }
}
