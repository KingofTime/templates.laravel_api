<?php

namespace App\Services\Base\Traits;

use App\Repositories\Base\Contracts\CreateBatchInterface;

trait CreateBatchMethods
{
    abstract protected function getRepository(): CreateBatchInterface;

    /**
     * @param  array<array<string, mixed>>  $data
     */
    public function createBatch(array $data): void
    {
        $this->getRepository()->createBatch($data);
    }
}
