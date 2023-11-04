<?php

namespace Tests\Unit\Repositories;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\UserRepository;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Resource extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function test_delete(): void
    {
        $repository = new UserRepository();
        $criteria = Query::eq('email', 'user.example1@email.com');
        $repository->delete($criteria);

        $users = User::where('email', 'user.example1@email.com')->get();
        $this->assertCount(0, $users);
    }

    public function test_delete_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $repository = new UserRepository();
        $criteria = Query::eq('email', 'not.found@email.com');
        $repository->delete($criteria);
    }

    public function test_delete_batch(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();

        $repository->deleteBatch($criteria);

        $users = User::all();
        $this->assertCount(0, $users);
    }

    public function test_delete_batch_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $repository = new UserRepository();
        $criteria = Query::eq('email', 'not.found@email.com');
        $repository->deleteBatch($criteria);
    }

    public function test_find_in_trash(): void
    {
        $user = User::where('email', 'user.example1@email.com')->first();
        $id = $user->id;
        $user->delete();

        $repository = new UserRepository();
        $deletedUser = $repository->findInTrash($id);
        $this->assertEquals($user, $deletedUser);
    }

    public function test_find_in_trash_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::where('email', 'user.example1@email.com')->first();
        $user->delete();

        $repository = new UserRepository();
        $repository->findInTrash(0);
    }

    public function test_first_in_trash(): void
    {
        $user = User::where('email', 'user.example1@email.com')->first();
        $user->delete();

        $repository = new UserRepository();
        $criteria = Query::eq('email', 'user.example1@email.com');
        $deletedUser = $repository->firstInTrash($criteria);
        $this->assertEquals($user, $deletedUser);
    }

    public function test_first_in_trash_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::where('email', 'user.example1@email.com')->first();
        $user->delete();

        $repository = new UserRepository();
        $criteria = Query::eq('email', 'notfound@email.com');
        $repository->firstInTrash($criteria);
    }

    public function test_get_in_trash(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();
        $repository->deleteBatch($criteria);

        $deletedUsers = $repository->getInTrash($criteria);
        $this->assertCount(5, $deletedUsers);

        $criteria = Query::lte('profile_id', 0);
        $deletedUsers = $repository->getInTrash($criteria);

        $this->assertIsIterable($deletedUsers);
        $this->assertCount(1, $deletedUsers);
    }

    public function test_get_in_trash_when_not_found(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();
        $repository->deleteBatch($criteria);

        $criteria = Query::eq('profile_id', -1);
        $users = $repository->getInTrash($criteria);

        $this->assertIsIterable($users);
        $this->assertCount(0, $users);
    }

    public function test_get_in_trash_with_order_by_and_sort(): void
    {
        User::insert([
            [
                'name' => 'B',
                'email' => 'alfabeto.b@email.com',
                'password' => '1234',
                'profile_id' => 1,
            ], [
                'name' => 'C',
                'email' => 'alfabeto.c@email.com',
                'password' => '1234',
                'profile_id' => 1,
            ],
        ]);

        $criteria = Query::all();
        $repository = new UserRepository();
        $repository->deleteBatch($criteria);

        $users = $repository->getInTrash($criteria, order_by: 'id', sort: 'desc');
        $this->assertCount(7, $users);
        $this->assertGreaterThan($users[1]->id, $users[0]->id);

        $criteria = Query::like('email', 'alfabeto');
        $users = $repository->getInTrash($criteria, order_by: 'name', sort: 'desc');

        $this->assertCount(2, $users);
        $this->assertEquals('C', $users[0]->name);
        $this->assertEquals('B', $users[1]->name);
    }

    public function test_paginate_in_trash(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();
        $repository->deleteBatch($criteria);

        $users = $repository->paginateInTrash($criteria, page: 1, per_page: 5, page_name: 'test');
        $this->assertCount(5, $users);

        $users = $repository->paginateInTrash($criteria, page: 1, per_page: 2, page_name: 'test');
        $this->assertCount(2, $users);

        $criteria = Query::lte('profile_id', 0);
        $users = $repository->paginateInTrash($criteria, page: 5, per_page: 1, page_name: 'test');

        $this->assertIsIterable($users);
        $this->assertCount(0, $users);
    }

    public function test_paginate_in_trash_not_found(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();
        $repository->deleteBatch($criteria);

        $users = $repository->paginate($criteria, page: 1, per_page: 5, page_name: 'test');
        $this->assertCount(0, $users);
    }

    public function test_paginate_in_trash_with_order_by_and_sort(): void
    {
        User::insert([
            [
                'name' => 'B',
                'email' => 'alfabeto.b@email.com',
                'password' => '1234',
                'profile_id' => 1,
            ], [
                'name' => 'C',
                'email' => 'alfabeto.c@email.com',
                'password' => '1234',
                'profile_id' => 1,
            ],
        ]);

        $criteria = Query::all();
        $repository = new UserRepository();
        $repository->deleteBatch($criteria);

        $users = $repository->paginateInTrash($criteria, page: 1, per_page: 5, page_name: 'test', order_by: 'id', sort: 'desc');
        $this->assertCount(5, $users);
        $this->assertGreaterThan($users[1]->id, $users[0]->id);

        $criteria = Query::like('email', 'alfabeto');
        $repository = new UserRepository();
        $users = $repository->paginateInTrash($criteria, page: 1, per_page: 5, page_name: 'test', order_by: 'name', sort: 'desc');

        $this->assertCount(2, $users);
        $this->assertEquals('C', $users[0]->name);
        $this->assertEquals('B', $users[1]->name);
    }

    public function test_restore(): void
    {
        $repository = new UserRepository();
        $criteria = Query::eq('email', 'user.example1@email.com');
        $repository->delete($criteria);

        $repository->restore($criteria);
        $users = User::where('email', 'user.example1@email.com')->get();
        $this->assertCount(1, $users);
    }

    public function test_restore_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $repository = new UserRepository();
        $criteria = Query::eq('profile_id', -1);
        $repository->restore($criteria);
    }

    public function test_restore_batch(): void
    {
        $repository = new UserRepository();
        $criteria = Query::all();
        $repository->deleteBatch($criteria);

        $repository->restoreBatch($criteria);
        $users = User::all();
        $this->assertCount(5, $users);
    }

    public function test_restore_batch_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $repository = new UserRepository();
        $criteria = Query::eq('profile_id', -1);
        $repository->restoreBatch($criteria);
    }

    public function test_force_delete(): void
    {
        $repository = new UserRepository();
        $criteria = Query::eq('email', 'user.example1@email.com');
        $repository->delete($criteria);
        $repository->forceDelete($criteria);

        $users = User::where('email', 'user.example1@email.com')
            ->onlyTrashed()
            ->get();

        $deletedUsers = User::where('email', 'user.example1@email.com')
            ->get();

        $this->assertCount(0, $users);
        $this->assertCount(0, $deletedUsers);
    }

    public function test_force_delete_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $repository = new UserRepository();
        $criteria = Query::eq('email', 'notfound@email.com');
        $repository->forceDelete($criteria);
    }

    public function test_force_delete_batch(): void
    {
        $repository = new UserRepository();
        $criteria = Query::all();
        $repository->deleteBatch($criteria);
        $repository->forceDeleteBatch($criteria);

        $users = User::all();
        $deletedUsers = User::onlyTrashed()->get();

        $this->assertCount(0, $users);
        $this->assertCount(0, $deletedUsers);
    }

    public function test_force_delete_batch_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $repository = new UserRepository();
        $criteria = Query::eq('profile_id', -1);
        $repository->forceDeleteBatch($criteria);
    }
}
