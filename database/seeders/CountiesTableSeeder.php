<?php

namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class CountiesTableSeeder extends Seeder
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

        foreach ($json as $data) {
            $county = new County();
            $county->name = $data['name'];
            $county->save();
        }
    }
}
