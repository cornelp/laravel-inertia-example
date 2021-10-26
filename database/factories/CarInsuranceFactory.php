<?php

namespace Database\Factories;

use App\Models\CarInsurance;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarInsuranceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarInsurance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'car_id' => rand(1, 50),
            'date' => now()->subDays(rand(5, 100)),
            'issuer' => $this->faker->domainName,
            'class' => 'B' . rand(0, 4),
            'amount' => rand(100, 10000),
            'validityInMonths' => array_rand([12, 24])
        ];
    }
}
