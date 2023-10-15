<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    abstract protected function getModel(): Model;
}
