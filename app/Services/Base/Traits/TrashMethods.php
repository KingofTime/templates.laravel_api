<?php

namespace App\Services\Base\Traits;

use App\Repositories\Base\Contracts\TrashInterface;

trait TrashMethods
{
    abstract protected function getRepository(): TrashInterface;

    use ForceRemoveMethods;
    use ListTrashedMethods;
    use PaginateTrashedMethods;
    use RestoreMethods;
    use RetrieveTrashedMethods;
}
