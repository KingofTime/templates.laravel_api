<?php

namespace App\Services\Base\Contracts;

interface CreateBatchInterface
{
    /**
     * @param  array<array<string, mixed>>  $data
     */
    public function createBatch(array $data): void;
}
