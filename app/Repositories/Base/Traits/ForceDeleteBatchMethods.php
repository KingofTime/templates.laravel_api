<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ForceDeleteBatchMethods
{
    public function forceDeleteBatch(CriteriaInterface $criteria): void
    {
        $builder = $criteria->apply($this->getModel())
            ->onlyTrashed();

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->forceDelete();
    }
}
