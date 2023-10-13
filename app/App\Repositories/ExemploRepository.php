<?php

namespace App\Repositories;

use App\Models\Exemplo;
use App\Repositories\Base\ResourceRepository;
use App\Repositories\Base\Traits\TrashMethods;

class ExemploRepository extends ResourceRepository
{
    use TrashMethods;

    protected function getModel(): Exemplo
    {
        return new Exemplo();
    }
}
