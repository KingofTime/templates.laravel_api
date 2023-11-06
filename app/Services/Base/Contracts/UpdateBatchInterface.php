<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface UpdateBatchInterface
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function updateBatch(CriteriaInterface $criteria, array $data): void;
}
