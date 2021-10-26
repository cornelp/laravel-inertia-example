<?php

namespace App\Http\Controllers;

use App\Enums\AreaType;
use App\Enums\CityType;
use App\Enums\DebtType;
use App\Http\Requests\StoreDebtRequest;
use App\Http\Requests\UpdateDebtRequest;
use App\Http\Resources\DebtResource;
use App\Models\Debt;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->applyQueryOnModel(
            $query = Debt::query(),
            $query = $this->getQueryFromRequest($request)
        );

        return Inertia::render('Debt/Index', [
            'items' => DebtResource::collection($data),
            'query' => $query,
            'options' => [
                'type' => DebtType::asArrayOfObjects(),
                'area' => AreaType::asArrayOfObjects(),
                'city' => CityType::asArrayOfObjects(),
            ]
        ]);
    }

    public function show(Debt $debt)
    {
        return Inertia::render('Debt/ShowCreate', [
            'model' => $debt,
            'options' => [
                'area' => AreaType::asArrayOfObjects(),
                'city' => CityType::asArrayOfObjects(),
                'type' => DebtType::asArrayOfObjects(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Debt/ShowCreate', [
            'options' => [
                'city' => CityType::asArrayOfObjects(),
                'area' => AreaType::asArrayOfObjects(),
                'type' => DebtType::asArrayOfObjects(),
            ]
        ]);
    }

    public function update(Debt $debt, UpdateDebtRequest $request)
    {
        $debt->update($request->validated());

        return response()
            ->redirectToRoute('debts.index')
            ->withStatus('Updated successfully.');
    }

    public function store(StoreDebtRequest $request)
    {
        Debt::create($request->validated());

        return response()
            ->redirectToRoute('debts.index')
            ->withStatus('Updated successfully.');
    }
}
