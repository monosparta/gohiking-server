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
        function autoIncrementTweak($id)
        {
            $range = 4; // 根據ClearDB設定
            return $id * 10 - 10 + $range;

            // return $id; // 本機設定
        }
        
        $this->call(CountiesTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(CollectionsTableSeeder::class);
        $this->call(CollectionTrailTableSeeder::class);
        $this->call(ArticlesSeeder::class);
        $this->call(ClassificationsSeeder::class);
        $this->call(TrailsTableSeeder::class);
        $this->call(UsersSeeder::class);
    }
}
