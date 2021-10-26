<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Http\Resources\PhoneResource;
use App\Models\Agent;
use App\Models\Phone;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PhoneController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->applyQueryOnModel(
            Phone::with('agent'),
            $query = $this->getQueryFromRequest($request)
        );

        return Inertia::render('Phone/Index', [
            'items' => PhoneResource::collection($data),
            'query' => $query,
        ]);
    }

    public function create()
    {
        $agents = $this->fetchAgents();

        return Inertia::render('Phone/ShowCreate', [
            'agents' => $agents
        ]);
    }

    public function store(StorePhoneRequest $request)
    {
        $phone = Phone::create($request->validated());

        $this->handleAgent($phone, $request->agent);

        return response()->redirectToRoute('phones.index');
    }

    public function update(Phone $phone, UpdatePhoneRequest $request)
    {
        $phone->update($request->validated());

        $this->handleAgent($phone, $request->agent);

        return response()
            ->redirectToRoute('phones.index')
            ->with('status', 'Updated successfully');
    }

    public function show(Phone $phone)
    {
        $phone->load([
            'agent' => fn ($q) => $q->select('id', 'name', 'phone_id')
        ]);

        $agents = $this->fetchAgents(
            $phone->agent?->id
        );

        return Inertia::render('Phone/ShowCreate', [
            'model' => $phone,
            'agents' => $agents
        ]);
    }

    protected function fetchAgents(?int $agentId = null)
    {
        return Agent::actives()
            ->whereDoesntHave('phone')
            ->when($agentId, fn ($q) => $q->orWhere('id', $agentId))
            ->get(['id', 'name'])
            ->toArray();
    }

    protected function handleAgent(Phone $phone, ?int $agentId = null): void
    {
        $agent = $agentId
            ? Agent::find($agentId)
            : $phone->agent()->first();

        if (!$agent) {
            return;
        }

        $agent->phone = $agentId ? $phone->id : null;
        $agent->save();
    }
}
