<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\RestoreInterface;

trait RestoreMethods
{
    abstract protected function getRepository(): RestoreInterface;

    public function restore(CriteriaInterface $criteria): void
    {
        $this->getRepository()->restore($criteria);
    }
}
