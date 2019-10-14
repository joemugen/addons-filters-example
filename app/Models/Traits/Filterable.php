<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $builder, $request, array $filters = []): ?Builder
    {
        try {
            $class = $this->getFilterableClass();

            return (new $class($request))->filter($builder);
        } catch (\Exception $exception) {
            return $builder;
        }
    }

    public function getFilterableClass()
    {
        return $this->filterableClass;
    }
}
