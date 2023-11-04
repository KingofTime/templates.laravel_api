<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\Repository;
use App\Repositories\Base\Traits\CRUDMethods;
use App\Repositories\Base\Traits\TrashMethods;

class UserRepository extends Repository
{
    use CRUDMethods;
    use TrashMethods;

    protected function getModel(): User
    {
        return new User();
    }
}

/**
 * retrieve
 * list
 * paginate
 * create
 * create batch
 * update
 * update batch
 * remove
 * remove batch
 * force remove
 * force remove batch
 */
