<?php

namespace Database\Factories;

use App\Models\SightsApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class SightsApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SightsApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $route_id = $this->faker->randomElement(RouteApplication::pluck('id')->toArray());
        $priority = SightApplication::where('route_id', $route_id)->count() + 1;
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(255),
            'latitude' => $this->faker->latitude(55, 57),
            'longitude' => $this->faker->longitude(36, 38),
            'priority' => $priority,
            'route_id' => $route_id,
            'photos' => json_encode(['test.jpg']),
            'status' => $this->faker->numberBetween(0, 3),
        ];
    }
}
