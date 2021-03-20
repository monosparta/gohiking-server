<?php

namespace Database\Factories;

use App\Models\Classification;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $str = '';
        return [
            'title' => $this->faker->catchPhrase,
            'content' => $this->random($str),
            'image' => 'https://picsum.photos/500/400?random=' . rand(1, 100)
        ];
    }

    private function random($str)
    {
        $count = 0;
        while ($count < rand(1, 5)) {
            $str .= $this->faker->catchPhrase;
            $count++;
        }
        return $str;
    }
}
