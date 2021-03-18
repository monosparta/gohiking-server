<?php

namespace Database\Seeders;

use App\Models\UserTrail;
use Illuminate\Database\Seeder;

class UserTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserTrail::factory()->count(10)->create();
    }
}
