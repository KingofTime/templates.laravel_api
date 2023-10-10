<?php

namespace App\Criterias\Base;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class OperatorCriteria implements CriteriaInterface
{
    public function __construct(
        protected string $field,
        protected mixed $value
    ) {
    }

    /**
     * @param Model|Builder<Model> $builder
     * @return Model|Builder<Model>
     */
    abstract public function apply(Model|Builder $builder): Model|Builder;
}
