<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\ResourceRepository;
use App\Repositories\Base\Traits\AggregationMethods;
use App\Repositories\Base\Traits\TrashMethods;

class UserRepository extends ResourceRepository
{
    use AggregationMethods;
    use TrashMethods;

    protected function getModel(): User
    {
        return new User();
    }
}
