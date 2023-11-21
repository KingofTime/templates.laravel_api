<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface ForceRemoveBatchInterface
{
    public function forceRemoveBatch(CriteriaInterface $criteria): void;
}
