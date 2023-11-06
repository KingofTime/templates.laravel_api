<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RemoveInterface
{
    public function remove(CriteriaInterface $criteria): void;
}
