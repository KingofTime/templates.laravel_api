<?php

namespace App\Repositories;

use App\Repositories\Base\ResourceRepository;
use App\Repositories\Base\Traits\TrashMethods;
use App\Repositories\Base\Traits\AggregationMethods;

use App\Models\User;

class UserRepository extends ResourceRepository
{
    use TrashMethods;
	use AggregationMethods;
	

    protected function getModel(): User
    {
        return new User();
    }
}
