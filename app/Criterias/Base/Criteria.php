<?php

namespace App\Criterias\Base;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Criteria implements CriteriaInterface
{
    /**
     * @param Model|Builder<Model> $builder
     * @return Model|Builder<Model>
     */
    public function apply(Model|Builder $builder): Model|Builder
    {
        return $builder;
    }
}
