<?php

namespace App\Repositories\Base\Traits;

use Illuminate\Database\Eloquent\Model;

trait CreateBatchMethods
{
    abstract protected function getModel(): Model;

    /**
     * @param  array<array<string, mixed>>  $data
     */
    public function createBatch(array $data): void
    {
        $this->getModel()::insert($data);
    }
}
