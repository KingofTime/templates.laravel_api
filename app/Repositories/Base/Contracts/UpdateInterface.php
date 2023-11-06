<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface UpdateInterface
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function update(CriteriaInterface $criteria, array $data): void;
}
