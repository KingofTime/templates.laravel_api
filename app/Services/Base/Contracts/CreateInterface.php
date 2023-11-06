<?php

namespace App\Services\Base\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CreateInterface
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Model;
}
