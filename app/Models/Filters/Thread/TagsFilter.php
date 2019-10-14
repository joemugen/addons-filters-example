<?php

namespace App\Models\Filters\Thread;

use App\Models\Filters\FilterAbstract;
use Illuminate\Support\Facades\DB;

class TagsFilter extends FilterAbstract
{
    /**
     * @var array
     */
    private $tags = [];

    public const TAGS_SEPARATOR = ',';

    public function filter($builder, $value)
    {
        try {
            $this->setTags($value);

            if ($this->hasTags()) {
                $builder->havingTags($this->tags);
            }

            return $builder;
        } catch (\Exception $exception) {
            return $builder;
        }
    }

    private function setTags($value): void
    {
        $tags = explode(self::TAGS_SEPARATOR, $value);

        if (count($tags) > 0) {
            $this->tags = $tags;
        }
    }

    private function hasTags(): bool
    {
        return empty($this->tags);
    }
}
