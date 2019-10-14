<?php

namespace App\Models\Filters\Thread;

use App\Models\Filters\FilterAbstract;

class RepliedFilter extends FilterAbstract
{
    public function mappings(): array
    {
        return [
            'true' => true,
            'false' => false,
            '1' => true,
            '0' => false,
        ];
    }

    public function filter($builder, $value)
    {
        try {
            if ($this->wantsThreadWithoutReplies($value)) {
                return $builder->doesntHaveReplies();
            }

            return $builder->hasReplies();
        } catch (\Exception $exception) {
            return $builder;
        }
    }

    private function wantsThreadWithoutReplies($value): bool
    {
        return !$this->wantsThreadWithReplies($value);
    }

    private function wantsThreadWithReplies($value): bool
    {
        return $this->resolveFilterValue($value);
    }
}
