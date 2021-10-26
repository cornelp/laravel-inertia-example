<?php

namespace App\Http\Controllers\Car;

use App\Enums\CarReviewType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarReviewRequest;
use App\Http\Requests\UpdateCarReviewRequest;
use App\Http\Resources\CarReviewResource;
use App\Models\Agent;
use App\Models\Car;
use App\Models\CarReview;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarReviewController extends Controller
{
    public function index(Car $car, Request $request)
    {
        $data = $this->applyQueryOnModel(
            $car->reviews()->with(['agent' => fn ($q) => $q->select('id', 'name')]),
            $query = $this->getQueryFromRequest($request)
        );

        return Inertia::render('Car/Review/Index', [
            'parent' => $car,
            'items' => CarReviewResource::collection($data),
            'query' => $query
        ]);
    }

    public function create(Car $car)
    {
        $agents = Agent::actives()->get(['id', 'name']);

        return Inertia::render('Car/Review/ShowCreate', [
            'parent' => $car,
            'options' => [
                'agent' => $agents,
                'type' => CarReviewType::asArrayOfObjects()
            ]
        ]);
    }

    public function show(Car $car, CarReview $carReview)
    {
        $carReview->load(['agent' => fn ($q) => $q->select(['id', 'name'])]);

        return Inertia::render('Car/Review/ShowCreate', [
            'parent' => $car,
            'model' => new CarReviewResource($carReview),
            'options' => [
                'agent' => Agent::actives()->get(['id', 'name']),
                'type' => CarReviewType::asArrayOfObjects()
            ]
        ]);
    }

    public function store(Car $car, StoreCarReviewRequest $request)
    {
        $car->reviews()->create($request->validated());

        return response()->redirectToRoute('review.index', [$car->id]);
    }

    public function update(Car $car, CarReview $carReview, UpdateCarReviewRequest $request)
    {
        $carReview->update($request->validated());

        return response()->redirectToRoute('review.index', [$car->id]);
    }
}
