<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BannerSeeder::class);
        $this->call(CountryCodeSeeder::class);
        $this->call(CountiesTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(CollectionsTableSeeder::class);
        $this->call(CollectionTrailTableSeeder::class);
        $this->call(ArticlesSeeder::class);
        $this->call(ClassificationsSeeder::class);
        $this->call(TrailsTableSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(UserTrailSeeder::class);
    }
}
