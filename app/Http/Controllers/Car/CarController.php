<?php

namespace App\Http\Controllers\Car;

use App\Enums\AreaType;
use App\Enums\CarModelType;
use App\Enums\CarType;
use App\Enums\CityType;
use App\Enums\FuelType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Agent;
use App\Models\Car;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->applyQueryOnModel(
            Car::with(['agent' => fn ($q) => $q->select('id', 'name')]),
            $query = $this->getQueryFromRequest($request)
        );

        return Inertia::render('Car/Index', [
            'items' => CarResource::collection($data),
            'query' => $query,
            'options' => [
                'area' => AreaType::asArrayOfObjects(),
                'city' => CityType::asArrayOfObjects(),
                'model' => CarModelType::asArrayOfObjects(),
                'fuel' => FuelType::asArrayOfObjects(),
                'type' => CarType::asArrayOfObjects(),
                'model' => CarModelType::asArrayOfObjects(),
            ]
        ]);
    }

    public function create()
    {
        $agents = $this->fetchAgents();

        return Inertia::render('Car/ShowCreate', [
            'options' => [
                'agent' => $agents,
                'area' => AreaType::asArrayOfObjects(),
                'city' => CityType::asArrayOfObjects(),
                'model' => CarModelType::asArrayOfObjects(),
                'fuel' => FuelType::asArrayOfObjects(),
                'type' => CarType::asArrayOfObjects(),
                'model' => CarModelType::asArrayOfObjects(),
            ]
        ]);
    }

    public function show(Car $car)
    {
        $car->load([
            'agent' => fn ($q) => $q->select('id', 'name')
        ]);

        $agents = $this->fetchAgents($car->agentId);

        return Inertia::render('Car/ShowCreate', [
            'model' => $car,
            'options' => [
                'agent' => $agents,
                'area' => AreaType::asArrayOfObjects(),
                'city' => CityType::asArrayOfObjects(),
                'model' => CarModelType::asArrayOfObjects(),
                'fuel' => FuelType::asArrayOfObjects(),
                'type' => CarType::asArrayOfObjects(),
                'model' => CarModelType::asArrayOfObjects(),
            ]
        ]);
    }

    public function update(Car $car, UpdateCarRequest $request)
    {
        $car->update($request->validated());

        return response()
            ->redirectToRoute('cars.show', [$car->id])
            ->withFlash('Updated successfully');
    }

    public function store(StoreCarRequest $request)
    {
        $car = Car::create($request->validated());

        return response()->redirectToRoute('cars.show', [$car->id]);
    }

    protected function fetchAgents(?int $agentId = null): array
    {
        return Agent::whereDoesntHave('car')
            ->when($agentId, fn ($q) => $q->orWhereIn('id', [$agentId]))
            ->get(['id', 'name'])
            ->toArray();
    }
}
