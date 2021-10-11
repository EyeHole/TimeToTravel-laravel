<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->randomElement(User::pluck('id')->toArray());
        return [
            'description' => $this->faker->text(255),
            'status' => $this->faker->numberBetween(0, 3),
            'user_id' => $user_id
        ];
    }
}
