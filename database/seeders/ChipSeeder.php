<?php

namespace Database\Seeders;

use App\Models\Chip;
use Illuminate\Database\Seeder;

class ChipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chips=[
            "區域級步道",
            "中央山脈",
            "湖泊",
            "檜木",
            "運材軌道",
            "高山湖泊",
            "山毛櫸",
            "苔蘚"
        ];
        foreach($chips as $chip)
        {
            $newchip=new Chip();
            $newchip->name=$chip;
            $newchip->save();
        }
    }
}
