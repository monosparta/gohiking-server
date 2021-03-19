<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->swiftBicNumber,
            'gender' =>  $this->faker->boolean ? '1' : '0',
            'image' => 'https://picsum.photos/500/400?random=' . rand(1, 100),
            'phone_number' =>  '09' . rand(00000001, 99999999),
            'birth' =>  $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'county_id' => $this->faker->numberBetween(1, 10),
            'country_code_id' => rand(1, 10)
        ];
    }
}
