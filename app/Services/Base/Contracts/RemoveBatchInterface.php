<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RemoveBatchInterface extends ServiceInterface
{
    public function removeBatch(CriteriaInterface $criteria): void;
}
