<?php

namespace Database\Factories;

use App\Models\DebtDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class DebtDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DebtDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => rand(1000, 5000),
            'date' => $this->faker->date(),
            'amount' => rand(500, 1500),
            'type' => rand(1, 2)
        ];
    }
}
