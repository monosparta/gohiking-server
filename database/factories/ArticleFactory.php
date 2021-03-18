<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;


class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

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
            'image' => 'https://picsum.photos/500/400?random=' . rand(1, 100)
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
