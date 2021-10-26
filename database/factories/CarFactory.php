<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'area' => rand(1, 3),
            'city' => rand(1, 2),
            'license_no' => $this->faker->colorName,
            'model' => rand(1, 2),
            'agent' => rand(1, 3),
            'fuel' => rand(1, 2),
            'production_year' => 2000,
            'purchase_year' => 2017,
            'type' => rand(1, 2),
            'engine_capacity' => 1399,
            'revision_in_km' => 15000,
            'horse_power' => 55,
            'chassis' => $this->faker->bankAccountNumber,
            'insurance_till_date' => now()->subDays(rand(10, 100)),
            'road_tax_till_date' => now()->subDays(rand(100, 200)),
            'tehnical_inspection_till_date' => now()->subDays(rand(400, 500)),
            'fuel_card' => $this->faker->countryCode,
            'fuel_pin' => rand(5000, 6800),
            'consumption' => 5.91,
            'needs_road_tax' => false,
            'distribution_in_years' => 4,
            'distribution_in_km' => 60000,
        ];
    }
}
