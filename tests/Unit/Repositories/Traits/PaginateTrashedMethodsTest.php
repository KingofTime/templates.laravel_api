<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\PaginateTrashedMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginateTrashedMethodsTest extends TestCase
{
    use PaginateTrashedMethods;
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

    public function testPaginateInTrashed(): void
    {
        $criteria = Query::all();
        $users = $this->paginateInTrash($criteria, page: 1, per_page: 5, page_name: 'test');

        $this->assertIsIterable($users);
        $this->assertCount(5, $users);

        $users = $this->paginateInTrash($criteria, page: 1, per_page: 2, page_name: 'test');

        $this->assertIsIterable($users);
        $this->assertCount(2, $users);

        $users = $this->paginateInTrash($criteria, page: 3, per_page: 2, page_name: 'test');

        $this->assertIsIterable($users);
        $this->assertCount(1, $users);

        $users = $this->paginateInTrash($criteria, page: 5, per_page: 2, page_name: 'test');

        $this->assertIsIterable($users);
        $this->assertCount(0, $users);
    }

    public function testPaginateInTrashedWhenNotFound(): void
    {
        $criteria = Query::eq('profile_id', -1);
        $users = $this->paginateInTrash($criteria, page: 1, per_page: 5, page_name: 'test');

        $this->assertIsIterable($users);
        $this->assertCount(0, $users);
    }

    public function testPaginateInTrashedWithSorting(): void
    {
        $criteria = Query::all();
        $users = $this->paginateInTrash($criteria, page: 1, per_page: 5, page_name: 'test', order_by: 'id', sort: 'desc');

        $this->assertCount(5, $users);
        $this->assertGreaterThan($users[1]->id, $users[0]->id);

        User::insert([
            ['name' => 'B', 'email' => 'alfabeto.b@email.com', 'password' => '1234', 'profile_id' => 1],
            ['name' => 'C', 'email' => 'alfabeto.c@email.com', 'password' => '1234', 'profile_id' => 1],
        ]);

        $criteria = Query::like('email', 'alfabeto');
        $criteria->apply($this->getModel())->delete();

        $users = $this->paginateInTrash($criteria, page: 1, per_page: 5, page_name: 'test', order_by: 'name', sort: 'desc');

        $this->assertCount(2, $users);
        $this->assertEquals('C', $users[0]->name);
        $this->assertEquals('B', $users[1]->name);
    }
}
