<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AutoIncrementTweak extends Seeder
{
    /**
     * Run the database seeds.
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
    }
}
