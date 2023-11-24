<?php

namespace App\Repositories\Base\Contracts;

use App\Criterias\Contracts\CriteriaInterface;

interface UpdateInterface extends RepositoryInterface
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function update(CriteriaInterface $criteria, array $data): void;
}
