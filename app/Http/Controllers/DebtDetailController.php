<?php

namespace App\Http\Controllers;

use App\Enums\BankType;
use App\Enums\DebtDetailType;
use App\Http\Requests\StoreDebtDetailRequest;
use App\Http\Resources\DebtDetailResource;
use App\Models\Debt;
use App\Models\DebtDetail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DebtDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Debt $debt, Request $request)
    {
        $data = $this->applyQueryOnModel(
            $debt->details()->getQuery(),
            $query = $this->getQueryFromRequest($request)
        );

        return Inertia::render('Debt/Detail/Index', [
            'parent' => $debt,
            'items' => DebtDetailResource::collection($data),
            'query' => $query,
            'debt' => $debt,
            'options' => [
                'banks' => BankType::asArrayOfObjects(),
                'types' => DebtDetailType::asArrayOfObjects()
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Debt $debt)
    {
        return Inertia::render('Debt/Detail/ShowCreate', [
            'parent' => $debt,
            'options' => [
                'banks' => BankType::asArrayOfObjects(),
                'types' => DebtDetailType::asArrayOfObjects()
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Debt $debt, StoreDebtDetailRequest $request)
    {
        $debt->details()->create(
            $request->validated()
        );

        return response()
            ->redirectToRoute('details.index', [$debt->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DebtDetail  $debtDetail
     * @return \Illuminate\Http\Response
     */
    public function show(Debt $debt, DebtDetail $debtDetail)
    {
        return Inertia::render('Debt/Detail/ShowCreate', [
            'parent' => $debt,
            'model' => $debtDetail,
            'options' => [
                'banks' => BankType::asArrayOfObjects(),
                'types' => DebtDetailType::asArrayOfObjects()
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DebtDetail  $debtDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Debt $debt, DebtDetail $debtDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DebtDetail  $debtDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Debt $debt, DebtDetail $debtDetail)
    {
        $debtDetail->delete();

        return response()
            ->redirectToRoute('details.destroy');
    }
}
