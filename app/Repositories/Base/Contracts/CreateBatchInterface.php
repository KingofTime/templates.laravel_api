<?php

namespace App\Repositories\Base\Contracts;

interface CreateBatchInterface extends RepositoryInterface
{
    /**
     * @param  array<array<string, mixed>>  $data
     */
    public function createBatch(array $data): void;
}
