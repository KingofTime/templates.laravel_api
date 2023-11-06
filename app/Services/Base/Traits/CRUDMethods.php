<?php

namespace App\Services\Base\Traits;

trait CRUDMethods
{
    use CreateMethods;
    use ListMethods;
    use PaginateMethods;
    use RemoveMethods;
    use RetrieveMethods;
    use UpdateMethods;
}
