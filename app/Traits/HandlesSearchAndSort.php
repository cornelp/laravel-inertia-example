<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HandlesSearchAndSort
{
    public function scopeSearch($q, ?string $term = null)
    {
        if (!$term) {
            return;
        }

        $q->where(
            fn ($q) => collect($this->searchFields ?? [])->each(
                // fn ($field) => $q->orWhere(Str::snake($field), 'LIKE', "%$term%")
                function ($field) use ($term, $q) {
                    $parts = explode('.', $field);

                    if (count($parts) > 1) {
                        $q->orWhereHas($parts[0], fn ($q) => $q->where(Str::snake($parts[1]), 'LIKE', "%$term%"));
                    } else {
                        $q->orWhere(Str::snake($field), 'LIKE', "%$term%");
                    }
                }
            )
        );
    }

    public function scopeHandleSort($q, array $sortBy = [], array $sortDesc = [])
    {
        if (!count($sortBy)) {
            return;
        }

        collect($sortBy)
            ->each(
                fn ($item, $index) => $q->orderBy($item, isset($sortDesc[$index]) && $sortDesc[$index] === true ? 'desc' : 'asc')
            );
    }

    public function scopeHandleFilters($q, ?array $filters = null)
    {
        if (!$filters) {
            return;
        }

        collect($filters)->each(function ($filter, $name) use ($q) {
            $name = Str::snake($name);

            $position = strpos(strtolower($name), 'date');

            $position !== false && $position >= 0
                ? $q->whereBetween($name, $filter)
                : $q->whereIn($name, $filter);
        });
    }
}
