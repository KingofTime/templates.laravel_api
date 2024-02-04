<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\RestoreBatchInterface;

trait RestoreBatchMethods
{
    abstract protected function getRepository(): RestoreBatchInterface;

    public function restoreBatch(CriteriaInterface $criteria): void
    {
        $this->getRepository()->restoreBatch($criteria);
    }
}
