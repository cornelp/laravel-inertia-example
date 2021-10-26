<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFuelRequest;
use App\Http\Requests\UpdateFuelRequest;
use App\Http\Resources\FuelResource;
use App\Models\Agent;
use App\Models\Car;
use App\Models\Fuel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarFuelController extends Controller
{
    public function index(Request $request, Car $car)
    {
        $modelQuery = $car->fuelSupplies()
            ->with([
                'agent' => fn ($q) => $q->select('id', 'name'),
                'car' => fn ($q) => $q->select('id', 'license_no'),
            ]);

        $data = $this->applyQueryOnModel(
            $modelQuery,
            $query = $this->getQueryFromRequest($request)
        );

        return Inertia::render('Car/Fuel/Index', [
            'parent' => $car,
            'items' => FuelResource::collection($data),
            'query' => $query,
        ]);
    }

    public function create(Car $car)
    {
        return Inertia::render('Car/Fuel/ShowCreate', [
            'parent' => $car,
            'options' => [
                'agent' => Agent::get(['id', 'name'])
            ]
        ]);
    }

    public function show(Car $car, Fuel $fuel)
    {
        $fuel->load([
            'car' => fn ($q) => $q->select('id', 'license_no'),
            'agent' => fn ($q) => $q->select('id', 'name')
        ]);

        $agents = Agent::get(['id', 'name']);

        return Inertia::render('Car/Fuel/ShowCreate', [
            'model' => $fuel,
            'parent' => $car,
            'options' => [
                'agent' => $agents,
            ]
        ]);
    }

    public function store(Car $car, StoreFuelRequest $request)
    {
        $car->fuelSupplies()->create($request->validated());

        return response()->redirectToRoute('fuel.index', [$car->id]);
    }

    public function update(Car $car, Fuel $fuel, UpdateFuelRequest $request)
    {
        $fuel->update($request->validated());

        return response()->redirectToRoute('fuel.index', [$car->id]);
    }

    public function destroy(Car $car, Fuel $fuel)
    {
        $fuel->delete();

        return response()->redirectToRoute('fuel.index', [$car->id]);
    }
}
