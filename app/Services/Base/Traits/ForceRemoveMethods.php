<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\ForceRemoveInterface;

trait ForceRemoveMethods
{
    abstract protected function getRepository(): ForceRemoveInterface;

    public function forceRemove(CriteriaInterface $criteria): void
    {
        $this->getRepository()->forceRemove($criteria);
    }
}
