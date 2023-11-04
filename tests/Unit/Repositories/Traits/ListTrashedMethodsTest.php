<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\ListTrashedMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListTrashedMethodsTest extends TestCase
{
    use ListTrashedMethods;
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

    public function testListInTrashed(): void
    {
        $criteria = Query::all();
        $users = $this->listInTrash($criteria);

        $this->assertIsIterable($users);
        $this->assertCount(5, $users);

        $criteria = Query::lte('profile_id', 0);
        $users = $this->listInTrash($criteria);

        $this->assertIsIterable($users);
        $this->assertCount(1, $users);
    }

    public function testListInTrashedWhenNotFound(): void
    {
        $criteria = Query::eq('profile_id', -1);
        $users = $this->listInTrash($criteria);

        $this->assertIsIterable($users);
        $this->assertCount(0, $users);
    }

    public function testListInTrashedWithSorting(): void
    {
        $criteria = Query::all();
        $users = $this->listInTrash($criteria, order_by: 'id', sort: 'asc');

        $this->assertCount(5, $users);
        $this->assertGreaterThan($users[0]->id, $users[1]->id);

        User::insert([
            ['name' => 'B', 'email' => 'alfabeto.b@email.com', 'password' => '1234', 'profile_id' => 1],
            ['name' => 'C', 'email' => 'alfabeto.c@email.com', 'password' => '1234', 'profile_id' => 1],
        ]);

        $criteria = Query::like('email', 'alfabeto');
        $criteria->apply($this->getModel())->delete();

        $users = $this->listInTrash($criteria, order_by: 'name', sort: 'desc');

        $this->assertCount(2, $users);
        $this->assertEquals('C', $users[0]->name);
        $this->assertEquals('B', $users[1]->name);
    }
}
