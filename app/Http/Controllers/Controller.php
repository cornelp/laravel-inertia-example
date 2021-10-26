<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getQueryFromRequest(Request $request): array
    {
        $sortBy = collect($request->input('sortBy', []))
            ->transform(fn ($item) => Str::snake($item))
            ->toArray();
        $sortDesc = collect($request->input('sortDesc', []))
            ->transform(fn ($item) => $item === 'true')
            ->toArray();

        return [
            'filters' => $request->filters,
            'search' => $request->search,
            'sortBy' => $sortBy,
            'sortDesc' => $sortDesc,
            'page' => $request->input('page', 1),
            'itemsPerPage' => $request->input('itemsPerPage', 10),
        ];
    }

    public function applyQueryOnModel($builder, array $query)
    {
        return $builder
            ->search($query['search'])
            ->handleFilters($query['filters'])
            ->handleSort($query['sortBy'], $query['sortDesc'])
            ->paginate($query['itemsPerPage']);
    }
}
