<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>factoryAutoIncrementTweak(rand(1,10)),
            'trail_id'=>factoryAutoIncrementTweak(rand(1,6)),
            'date'=>$this->faker->date($format = 'Y-m-d', $max = 'now'),
            'star'=>rand(1,5),
            'difficulty'=>rand(1,5),
            'beauty'=>rand(1,5),
            'duration'=>rand(10,150),//minute
            'content'=> $this->random(),
            'likes'=>rand(20,30),
            'dislikes'=>rand(3,6),
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
