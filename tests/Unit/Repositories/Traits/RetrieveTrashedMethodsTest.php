<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\RetrieveTrashedMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveTrashedMethodsTest extends TestCase
{
    use RefreshDatabase;
    use RetrieveTrashedMethods;

    protected function getModel(): Model
    {
        return new User();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function testFindInTrash(): void
    {
        $user = User::where('email', 'user.example1@email.com')->firstOrFail();
        $id = $user->id;
        $user->delete();

        $this->assertEquals($user, $this->findInTrash($id));
    }

    public function testFindInTrashWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->findInTrash(-1);
    }

    public function testFirstInTrash(): void
    {
        $user = User::where('email', 'user.example1@email.com')->firstOrFail();
        $user->delete();

        $criteria = Query::eq('email', 'user.example1@email.com');
        $this->assertEquals($user, $this->firstInTrash($criteria));
    }

    public function testFirstInTrashWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('email', 'not.found@email.com');
        $this->firstInTrash($criteria);
    }

    public function testExistInTrash(): void
    {
        $criteria = Query::eq('name', 'User 0');
        $this->assertEquals(false, $this->existsInTrash($criteria));

        $user = User::where('name', 'User 0')->firstOrFail();
        $user->delete();

        $criteria = Query::eq('name', 'User 0');
        $this->assertEquals(true, $this->existsInTrash($criteria));
    }
}
