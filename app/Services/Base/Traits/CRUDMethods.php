<?php

namespace App\Services\Base\Traits;

use App\Repositories\Base\Contracts\CRUDInterface;

trait CRUDMethods
{
    abstract protected function getRepository(): CRUDInterface;

    use CreateMethods;
    use ListMethods;
    use PaginateMethods;
    use RemoveMethods;
    use RetrieveMethods;
    use UpdateMethods;
}
