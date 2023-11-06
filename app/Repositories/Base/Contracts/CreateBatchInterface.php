<?php

namespace App\Repositories\Base\Contracts;

interface CreateBatchInterface
{
    /**
     * @param  array<array<string, mixed>>  $data
     */
    public function createBatch(array $data): void;
}
