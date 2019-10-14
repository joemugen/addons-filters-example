<?php

namespace App\Models\Traits;

use Illuminate\Support\Arr;

trait Orderable
{
    public function scopeSort($builder, $sort)
    {
        return $builder->orderBy($this->resolveOrderAttribute($sort), $this->resolveOrderDirection($sort));
    }

    public function resolveOrderAttribute($sort)
    {
        $attribute = $sort[0] ?? $sort;

        return $this->isFillable($attribute) ? $attribute : $this->getKeyName();
    }

    public function resolveOrderDirection($sort)
    {
        $direction = $sort[1] ?? 'desc';

        return Arr::get([
            'desc' => 'desc',
            'asc' => 'asc'
        ], $direction, 'desc');
    }
}
