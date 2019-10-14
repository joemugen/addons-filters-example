<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class FiltersAbstract
{
    protected $request;

    protected $filters = [];

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function filter(Builder $builder): Builder
    {
        foreach ($this->getFilters() as $filter => $value) {
            $this->resolveFilter($filter)->filter($builder, $value);
        }

        return $builder;
    }

    protected function resolveFilter($filter)
    {
        return new $this->filters[$filter];
    }

    public function add(array $filters): FiltersAbstract
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    protected function getFilters(): array
    {
        return $this->filterFilters($this->filters);
    }

    protected function filterFilters($filters): array
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }
}
