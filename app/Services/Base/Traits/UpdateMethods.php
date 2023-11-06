<?php

namespace App\Services\Base\Traits;

use App\Criterias\Contracts\CriteriaInterface;
use App\Repositories\Base\Contracts\UpdateInterface;

trait UpdateMethods
{
    abstract protected function getRepository(): UpdateInterface;

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(CriteriaInterface $criteria, array $data): void
    {
        $this->getRepository()->update($criteria, $data);
    }
}
