<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\ForceRemoveBatchInterface;

trait ForceRemoveBatchMethods
{
    abstract protected function getRepository(): ForceRemoveBatchInterface;

    public function forceRemoveBatch(CriteriaInterface $criteria): void
    {
        $this->getRepository()->forceRemoveBatch($criteria);
    }
}
