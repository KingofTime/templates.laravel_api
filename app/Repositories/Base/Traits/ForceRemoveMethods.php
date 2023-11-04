<?php

namespace App\Repositories\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;

trait ForceRemoveMethods
{
    public function forceRemove(CriteriaInterface $criteria): void
    {
        $criteria->apply($this->getModel()) //@phpstan-ignore-line
            ->onlyTrashed()
            ->firstOrFail()
            ->forceDelete();
    }
}
