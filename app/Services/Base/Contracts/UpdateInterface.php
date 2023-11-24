<?php

namespace App\Services\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface UpdateInterface extends ServiceInterface
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function update(CriteriaInterface $criteria, array $data): void;
}
