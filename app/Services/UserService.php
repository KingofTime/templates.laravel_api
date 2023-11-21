<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\Base\Service;
use App\Services\Base\Contracts\CRUDInterface;
use App\Services\Base\Traits\CRUDMethods;
use App\Services\Base\Contracts\TrashInterface;
use App\Services\Base\Traits\TrashMethods;


class UserService extends Service implements CRUDInterface, TrashInterface
{
    use CRUDMethods;
	use TrashMethods;


    protected function getRepository(): UserRepository
    {
        return new UserRepository();
    }


}
