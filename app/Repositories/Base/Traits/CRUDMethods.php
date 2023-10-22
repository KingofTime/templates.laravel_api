<?php

namespace App\Repositories\Base\Traits;

trait CRUDMethods
{
    use CreateMethods;
    use DeleteMethods;
    use ListMethods;
    use PaginateMethods;
    use RetrieveMethods;
    use UpdateMethods;
}
