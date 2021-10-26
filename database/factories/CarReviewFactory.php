<?php

namespace Database\Factories;

use App\Models\CarReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarReview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'car' => rand(1, 50),
            'agent' => rand(1, 50),
            'date' => now()->subDays(rand(1, 50)),
            'invoice_date' => now()->subDays(rand(1, 50)),
            'type' => rand(1, 3),
            'mileage' => rand(10000, 99999),
            'amount' => rand(100, 10000),
            'observations' => $this->faker->sentence
        ];
    }
}
