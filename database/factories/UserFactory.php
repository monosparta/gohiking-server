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
            'phone_number' =>  $this->faker->tollFreePhoneNumber,
            'birth' =>  $this->faker->DateTime('2007-05-29 22:30:48', 'Europe/Paris'),
        ];
    }
}
