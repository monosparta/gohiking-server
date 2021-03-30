<?php

namespace Database\Seeders;

use App\Models\CountryCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class CountryCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = FacadesStorage::disk('local')->get('countryCode.json');
        $json = json_decode($json, true);

        foreach ($json as $key => $data) {
            $countryCode = new CountryCode();
            $countryCode->country_code = $data['countryCode'];
            $countryCode->country_name = $data['countryName'];
            $countryCode->phone_code = $data['phoneCode'];
            $countryCode->save();
        }
    }
}
