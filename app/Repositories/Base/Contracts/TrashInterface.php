<?php

namespace App\Repositories\Base\Contracts;

interface TrashInterface extends ForceRemoveInterface, ListTrashedInterface, PaginateTrashedInterface, RestoreInterface, RetrieveTrashedInterface
{
}
