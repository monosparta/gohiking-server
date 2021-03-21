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
        // 將產生密碼的變數移到上面，並改從後端顯示明碼
        $originalPassword = $this->faker->swiftBicNumber;
        error_log($originalPassword);        

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => bcrypt($originalPassword), // 僅儲存雜湊過的密碼，以符合資安邊準
            'gender' =>  $this->faker->boolean ? '1' : '0',
            'image' => 'https://picsum.photos/500/400?random=' . rand(1, 100),
            'phone_number' =>  $this->faker->phoneNumber,
            'birth' =>  $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'county_id' => autoIncrementTweak($this->faker->numberBetween(1, 10))
        ];
    }
}
