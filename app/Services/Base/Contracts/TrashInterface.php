<?php

namespace App\Services\Base\Contracts;

interface TrashInterface extends RetrieveTrashedInterface, ListTrashedInterface, PaginateTrashedInterface, RestoreInterface, ForceRemoveInterface
{

}
