<?php

namespace Database\Factories;

use App\Models\RouteApplication;
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
        $priority = SightsApplication::where('route_id', $route_id)->count() + 1;
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(255),
            'latitude' => $this->faker->latitude(55.6, 55.8),
            'longitude' => $this->faker->longitude(37.5, 37.8),
            'priority' => $priority,
            'route_id' => $route_id,
            'photos' => json_encode(['storage/test/sights/1/images/test.jpg', 'storage/test/sights/1/images/test.jpg']),
            'audio' => json_encode('storage/test/sights/1/audio/test.mp3'),
            'status' => $this->faker->numberBetween(0, 3),
        ];
    }
}
