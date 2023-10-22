<?php

namespace App\Repositories\Base\Traits;

trait TrashMethods
{
    use ForceDeleteMethods;
    use ListTrashedMethods;
    use PaginateTrashedMethods;
    use RestoreMethods;
    use RetrieveTrashedMethods;
}
