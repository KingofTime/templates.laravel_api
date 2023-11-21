<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface ForceRemoveInterface
{
    public function forceRemove(CriteriaInterface $criteria): void;
}
