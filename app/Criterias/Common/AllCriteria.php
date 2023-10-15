<?php

namespace App\Criterias\Common;

use App\Criterias\Base\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AllCriteria extends Criteria
{
    /**
     * {@inheritDoc}
     */
    public function apply(Model|Builder $builder): Model|Builder
    {
        if ($builder instanceof Builder) {
            return $builder;
        }

        return $builder::query();
    }
}
