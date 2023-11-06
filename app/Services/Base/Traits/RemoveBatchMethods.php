<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\RemoveBatchInterface;

trait RemoveBatchMethods
{
    abstract protected function getRepository(): RemoveBatchInterface;

    public function removeBatch(CriteriaInterface $criteria): void
    {
        $this->getRepository()->removeBatch($criteria);
    }
}
