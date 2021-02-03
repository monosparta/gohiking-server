<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('collections')->delete();
        $datas=[
            [
                'name'=>'賞楓',
                'iconImage'=>'mapple.png',
            ],[
                'name'=>'挑戰',
                'iconImage'=>'chellenge.png',

            ],[
                'name'=>'溫泉',
                'iconImage'=>'hotSpring.png',

            ],[
                'name'=>'親子',
                'iconImage'=>'family.png',
            ],[
                'name'=>'秘境',
                'iconImage'=>'forest.png',

            ],[
                'name'=>'桐花',
                'iconImage'=>'sakura.png',
            ],[
                'name'=>'露營',
                'iconImage'=>' ',
            ],
        ];
        foreach ($datas as $data) {
            DB::table('collections')->insert([
                'name' => $data['name'],
                'iconImage'=>$data['iconImage'],
                ]);
        }
    }
}
