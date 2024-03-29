<?php

namespace App\Repositories\Base\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CreateInterface extends RepositoryInterface
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Model;
}
