<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\ForceRemoveBatchMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForceRemoveBatchMethodsTest extends TestCase
{
    use ForceRemoveBatchMethods;
    use RefreshDatabase;

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

    public function testForceDeleteBatch(): void
    {
        $criteria = Query::all();
        $this->forceRemoveBatch($criteria);

        $users = User::all();
        $this->assertCount(0, $users);
    }

    public function testForceDeleteBatchWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('email', 'notfound@email.com');
        $this->forceRemoveBatch($criteria);
    }
}
