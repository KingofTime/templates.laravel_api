<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface RemoveInterface extends ServiceInterface
{
    public function remove(CriteriaInterface $criteria): void;
}
