<?php

namespace Database\Seeders;

use App\Models\CommentsImage;
use Illuminate\Database\Seeder;

class CommentsImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommentsImage::factory()->count(30)->create();
    }
}
