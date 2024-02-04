<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface ForceRemoveInterface extends ServiceInterface
{
    public function forceRemove(CriteriaInterface $criteria): void;
}
