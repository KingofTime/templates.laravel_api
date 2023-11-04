<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\ForceRemoveMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForceRemoveMethodsTest extends TestCase
{
    use ForceRemoveMethods;
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

    public function testForceDelete(): void
    {
        $criteria = Query::eq('email', 'user.example1@email.com');
        $this->forceRemove($criteria);

        $users = $criteria->apply($this->getModel())
            ->onlyTrashed()
            ->get();

        $this->assertCount(0, $users);
    }

    public function testForceDeleteWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('email', 'notfound@email.com');
        $this->forceRemove($criteria);
    }
}
