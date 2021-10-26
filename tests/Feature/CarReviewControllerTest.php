<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarReview;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class CarReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_mileage_when_adding_new_review()
    {
        // $this->withoutExceptionHandling();

        // create a car
        $car = Car::factory()->create();

        // add a review to it
        $carReview = CarReview::factory()->create([
            'car' => $car,
            'date' => now()->subDay()
        ]);

        // prepare data for post form
        $data = array_merge(CarReview::factory()->make()->toArray(), [
            'car' => $car->id,
            'date' => now(),
            'mileage' => $carReview->mileage - 1
        ]);

        // send the data and check for result
        $this->post("/cars/{$car->id}/review", $data)
            ->dump()
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Car/Review/ShowCreate')
            );
    }
}
