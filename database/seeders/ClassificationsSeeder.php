<?php

namespace Database\Seeders;

use App\Models\Classification;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class ClassificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = FacadesStorage::disk('local')->get('classification.json');
        $json = json_decode($json, true);

        foreach ($json as $key => $data) {
            $classification = new Classification();
            $classification->name = $data['name'];
            $classification->title = $data['subTitle'];
            $classification->image = $data['iconImage'];
            $classification->save();
        }
    }
}
