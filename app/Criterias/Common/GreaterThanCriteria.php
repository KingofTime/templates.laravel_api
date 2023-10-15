<?php

namespace App\Criterias\Common;

use App\Criterias\Base\OperatorCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GreaterThanCriteria extends OperatorCriteria
{
    public function __construct(string $field, int|float $value)
    {
        parent::__construct($field, $value);
    }

    /**
     * @param  Model|Builder<Model>  $builder
     * @return Model|Builder<Model>
     */
    public function apply(Model|Builder $builder): Model|Builder
    {
        return $builder->where(
            $this->field,
            '>',
            $this->value
        );
    }
}
