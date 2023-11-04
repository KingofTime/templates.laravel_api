<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\RestoreBatchMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestoreBatchMethodsTest extends TestCase
{
    use RefreshDatabase;
    use RestoreBatchMethods;

    protected function getModel(): Model
    {
        return new User();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
        Query::all()->apply($this->getModel())->delete();
    }

    public function testRestoreBatch(): void
    {
        $criteria = Query::all();
        $this->restoreBatch($criteria);

        $users = User::all();
        $this->assertCount(5, $users);
    }

    public function testRestoreBatchWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('profile_id', -1);
        $this->restoreBatch($criteria);
    }
}
