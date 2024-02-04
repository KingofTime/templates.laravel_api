<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RestoreInterface extends ServiceInterface
{
    public function restore(CriteriaInterface $criteria): void;
}
