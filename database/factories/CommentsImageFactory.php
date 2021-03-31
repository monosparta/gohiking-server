<?php

namespace Database\Factories;

use App\Models\CommentsImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentsImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommentsImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment_id'=>rand(1,10),
            'user_id'=>rand(1,10),
            's3_filePath'=>'imgs/1616989897.jpg',
            'tag_id'=>rand(1,12)
        ];
    }
}
