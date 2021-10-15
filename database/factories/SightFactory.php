<?php

namespace Database\Factories;

use App\Models\Sight;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class SightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sight::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $route_id = $this->faker->randomElement(Route::pluck('id')->toArray());
        $priority = Sight::where('route_id', $route_id)->count() + 1;
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(255),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'priority' => $priority,
            'route_id' => $route_id
        ];
    }
}