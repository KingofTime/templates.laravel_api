<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RestoreBatchInterface extends ServiceInterface
{
    public function restoreBatch(CriteriaInterface $criteria): void;
}
