<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\UpdateBatchInterface;

trait UpdateBatchMethods
{
    abstract protected function getRepository(): UpdateBatchInterface;

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateBatch(CriteriaInterface $criteria, array $data): void
    {
        $this->getRepository()->updateBatch($criteria, $data);
    }
}
