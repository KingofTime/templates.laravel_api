<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\RemoveBatchMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveBatchMethodsTest extends TestCase
{
    use RefreshDatabase;
    use RemoveBatchMethods;

    protected function getModel(): Model
    {
        return new User();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function testRemoveBatch(): void
    {
        $criteria = Query::all();
        $this->removeBatch($criteria);

        $users = User::all();
        $this->assertCount(0, $users);
    }

    public function testRemoveBatchWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('email', 'not.found@email.com');
        $this->removeBatch($criteria);
    }
}
