<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RemoveBatchInterface
{
    public function removeBatch(CriteriaInterface $criteria): void;
}
