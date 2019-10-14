<?php

namespace App\Models\Filters\Thread;

use App\Models\Filters\FilterAbstract;

class OwnerFilter extends FilterAbstract
{
    public function filter($builder, $value)
    {
        try {
            if ($value === null) {
                return $builder;
            }

            return $builder->where('owner_id', $value);
        } catch (\Exception $exception) {
            return $builder;
        }
    }
}
