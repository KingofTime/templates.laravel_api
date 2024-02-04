<?php

namespace App\Repositories\Base\Traits;

use Illuminate\Database\Eloquent\Model;

trait CRUDMethods
{
    abstract protected function getModel(): Model;

    use CreateMethods;
    use ListMethods;
    use PaginateMethods;
    use RemoveMethods;
    use RetrieveMethods;
    use UpdateMethods;
}
