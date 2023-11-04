<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\RetrieveMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveMethodsTest extends TestCase
{
    use RefreshDatabase;
    use RetrieveMethods;

    protected function getModel(): Model
    {
        return new User();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function testFind(): void
    {
        $firstUser = $this->getModel()::first();
        $user = $this->find($firstUser->id);

        $this->assertEquals($firstUser, $user);
    }

    public function testFindWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $id = 0;
        $this->find($id);
    }

    public function testFirst(): void
    {
        $criteria = Query::eq('email', 'user.example1@email.com');
        $user = $this->first($criteria);

        $this->assertEquals('User 1', $user->name);

        $criteria = Query::lte('profile_id', 5);
        $user = $this->first($criteria);

        $this->assertIsNotIterable($user);
    }

    public function testFirstWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('email', 'not.found@email.com');
        $this->first($criteria);
    }

    public function testExists(): void
    {
        $criteria = Query::eq('name', 'User 0');
        $this->assertEquals(true, $this->exists($criteria));

        $criteria = Query::eq('name', 'User Not Found');
        $this->assertEquals(false, $this->exists($criteria));
    }
}
