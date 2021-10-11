<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\User;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Route::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->randomElement(User::pluck('id')->toArray());
        $city_id = $this->faker->randomElement(City::pluck('id')->toArray());
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(255),
            'length' => $this->faker->randomFloat(2, 1, 20),
            'transport' => $this->faker->numberBetween(0, 3),
            'language' => $this->faker->numberBetween(0, 1),
            'user_id' => $user_id,
            'city_id' => $city_id
        ];
    }
}
