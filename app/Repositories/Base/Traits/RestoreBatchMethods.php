<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait RestoreBatchMethods
{
    abstract protected function getModel(): Model;

    public function restoreBatch(CriteriaInterface $criteria): void
    {
        $builder = $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed();

        if (count($builder->get()) == 0) {
            throw new ModelNotFoundException();
        }

        $builder->restore();
    }
}
