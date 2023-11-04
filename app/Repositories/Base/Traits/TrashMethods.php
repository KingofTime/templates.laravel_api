<?php

namespace App\Repositories\Base\Traits;

trait TrashMethods
{
    use ForceRemoveMethods;
    use ListTrashedMethods;
    use PaginateTrashedMethods;
    use RestoreMethods;
    use RetrieveTrashedMethods;
}
