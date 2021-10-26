<?php

namespace App\Http\Controllers;

use App\Enums\AreaType;
use App\Enums\CityType;
use App\Enums\CorType;
use App\Enums\PositionType;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Http\Resources\AgentResource;
use Inertia\Inertia;
use App\Models\Agent;
use App\Models\Phone;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->applyQueryOnModel(
            Agent::with(['phone' => fn ($q) => $q->select('id', 'number')]),
            $query = $this->getQueryFromRequest($request)
        );

        $phones = Phone::actives()
            ->whereHas('agent')
            ->get(['id', 'number'])
            ->toArray();

        return Inertia::render('Agent/Index', [
            'items' => AgentResource::collection($data),
            'query' => $query,
            'options' => [
                'area' => AreaType::asArrayOfObjects(),
                'icCity' => CityType::asArrayOfObjects(),
                'position' => PositionType::asArrayOfObjects(),
                'phoneId' => $phones
            ]
        ]);
    }

    public function show(Agent $agent)
    {
        return Inertia::render('Agent/ShowCreate', [
            'agent' => $agent,
            'areas' => AreaType::asArrayOfObjects(),
            'positions' => PositionType::asArrayOfObjects(),
            'cors' => CorType::asArrayOfObjects(),
            'phoneNumbers' => $this->getAvailablePhoneNumbers($agent->phoneId)
        ]);
    }

    public function update(Agent $agent, UpdateAgentRequest $request)
    {
        $agent->update($request->validated());

        return response()
            ->redirectToRoute('agents.index')
            ->withStatus('Updated successfully.');
    }

    public function store(StoreAgentRequest $request)
    {
        Agent::create($request->validated());

        return response()->redirectToRoute('agents.index');
    }

    public function create()
    {
        return Inertia::render('Agent/ShowCreate', [
            'areas' => AreaType::asArrayOfObjects(),
            'positions' => PositionType::asArrayOfObjects(),
            'cors' => CorType::asArrayOfObjects(),
            'phoneNumbers' => $this->getAvailablePhoneNumbers()
        ]);
    }

    protected function getAvailablePhoneNumbers(?int $phoneId = null): array
    {
        return Phone::actives()
            ->available()
            ->when($phoneId, fn ($q) => $q->orWhere('id', $phoneId))
            ->get(['id', 'number'])
            ->toArray();
    }

    public function destroy(Agent $agent)
    {
        if (!$agent->resignationDate) {
            $agent->update(['resignationDate' => now()]);
        }

        $agent->delete();

        return response()->redirectToRoute('agents.index');
    }

    public function restore(Agent $agent)
    {
        $agent->restore();

        return response()->redirectToRoute('agents.index');
    }
}
