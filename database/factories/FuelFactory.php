<?php

namespace Database\Factories;

use App\Models\Fuel;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fuel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'car' => rand(1, 100),
            'agent' => rand(1, 50),
            'mileage' => rand(10000, 100000),
            'amount' => rand(300, 500),
            'liters' => rand(50, 70),
        ];
    }
}
