<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait RemoveBatchMethods
{
    abstract protected function getModel(): Model;

    public function removeBatch(CriteriaInterface $criteria): void
    {
        $builder = $criteria->apply($this->getModel());

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->delete();
    }
}
