<?php

namespace App\Services\Base\Traits;

use App\Repositories\Base\Contracts\CreateInterface;
use Illuminate\Database\Eloquent\Model;

trait CreateMethods
{
    abstract protected function getRepository(): CreateInterface;

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Model
    {
        return $this->getRepository()->create($data);
    }
}
