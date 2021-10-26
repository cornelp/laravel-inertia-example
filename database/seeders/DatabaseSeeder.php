<?php

namespace Database\Seeders;

use App\Enums\DebtDetailType;
use App\Models\DebtDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Agent::factory(1000)->create();
        \App\Models\Phone::factory(10)->create();

        \App\Models\Debt::factory(100)
            ->create()
            ->each(function ($debt) {
                $debt->details()->create(
                    DebtDetail::factory()->make(['type' => DebtDetailType::INVOICE])->toArray()
                );

                $debt->details()->create(
                    DebtDetail::factory()->make(['type' => DebtDetailType::PAYMENT])->toArray()
                );
            });

        \App\Models\Car::factory(200)->create()
            ->each(function ($car) {
                $car->fuelSupplies()->create(
                    \App\Models\Fuel::factory()->make(['car' => $car])->toArray()
                );

                $car->reviews()->create(
                    \App\Models\CarReview::factory()->make(['car' => $car])->toArray()
                );
            });
    }
}
