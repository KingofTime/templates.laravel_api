<?php

namespace App\Criterias\Common;

use App\Criterias\Base\OperatorCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NotEqualCriteria extends OperatorCriteria
{
    /**
     * @param Model|Builder<Model> $builder
     * @return Model|Builder<Model>
     */
    public function apply(Model|Builder $builder): Model|Builder
    {
        return $builder->where(
            $this->field,
            '!=',
            $this->value
        );
    }
}
