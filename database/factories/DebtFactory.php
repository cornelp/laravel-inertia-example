<?php

namespace Database\Factories;

use App\Models\Debt;
use Illuminate\Database\Eloquent\Factories\Factory;

class DebtFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Debt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'area' => rand(1, 3),
            'city' => rand(1, 3),
            'name' => $this->faker->name,
            'tax_code' => $this->faker->unique()->countryCode,
            'bank_account' => $this->faker->unique()->bankAccountNumber,
            'bank' => 'Bank',
        ];
    }
}
