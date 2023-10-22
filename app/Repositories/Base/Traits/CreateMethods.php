<?php

namespace App\Repositories\Base\Traits;

use Illuminate\Database\Eloquent\Model;

trait CreateMethods
{
    abstract protected function getModel(): Model;

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Model
    {
        return $this->getModel()::create($data);
    }
}
