<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\RemoveInterface;

trait RemoveMethods
{
    abstract protected function getRepository(): RemoveInterface;

    public function remove(CriteriaInterface $criteria): void
    {
        $this->getRepository()->remove($criteria);
    }
}
