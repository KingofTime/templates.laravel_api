<?php

namespace App\Services\Base\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CreateInterface extends ServiceInterface
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Model;
}
