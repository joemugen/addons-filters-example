<?php

namespace App\Models\Filters;

use Illuminate\Support\Arr;

abstract class FilterAbstract
{
    abstract public function filter($builder, $value);

    /**
     * @return array
     */
    public function mappings(): array
    {
        return [];
    }

    protected function resolveFilterValue($key)
    {
        return Arr::get($this->mappings(), $key);
    }
}
