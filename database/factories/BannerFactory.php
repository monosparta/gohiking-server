<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->catchPhrase,
            'content' => $this->random(),
            'image' => 'https://picsum.photos/500/400?random=' . rand(1, 100),
            'link' => 'https://www.google.com/'
        ];
    }


    private function random($str = '')
    {
        $count = 0;
        while ($count < rand(1, 5)) {
            $str .= $this->faker->catchPhrase;
            $count++;
        }
        return $str;
    }
}
