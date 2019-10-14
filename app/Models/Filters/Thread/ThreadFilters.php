<?php

namespace App\Models\Filters\PrevisionBusinessDay;

use App\Models\Filters\FiltersAbstract;
use App\Models\Filters\Thread\OwnerFilter;
use App\Models\Filters\Thread\RepliedFilter;
use App\Models\Filters\Thread\TagsFilter;

class ThreadFilters extends FiltersAbstract
{
    protected $filters = [
        'owner' => OwnerFilter::class,
        'replied' => RepliedFilter::class,
        'tags' => TagsFilter::class,
    ];
}
