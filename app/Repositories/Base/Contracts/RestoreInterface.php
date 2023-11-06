<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RestoreInterface
{
    public function restore(CriteriaInterface $criteria): void;
}
