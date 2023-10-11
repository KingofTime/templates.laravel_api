<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;

trait AggregationMethods
{
    abstract protected function getModel(): Model;

    public function max(CriteriaInterface $criteria, string $field): mixed
    {
        return $criteria->apply($this->getModel())
            ->max($field);
    }
}
