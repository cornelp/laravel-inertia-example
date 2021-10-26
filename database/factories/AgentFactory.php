<?php

namespace Database\Factories;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contract_no' => $this->faker->unique()->buildingNumber,
            'name' => $this->faker->name,
            'area' => rand(1, 3),
            'hire_date' => now()->subDays(172),
            'birth_date' => now()->subYears(10),
            'cnp' => $this->faker->buildingNumber,
            'ic_serial' => $this->faker->citySuffix,
            'ic_number' => rand(1000, 9999),
            'address' => $this->faker->address,
            'ic_city' => $this->faker->city,
            'position' => rand(1, 3),
            'cor' => rand(1, 2),
            'resignation_date' => null,
        ];
    }
}
