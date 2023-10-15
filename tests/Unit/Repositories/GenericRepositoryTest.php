<?php

namespace Tests\Unit\Repositories;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\UserRepository;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PDOException;
use Tests\TestCase;

class GenericRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function test_find(): void
    {
        $firstUser = User::first();

        $repository = new UserRepository();
        $user = $repository->find($firstUser->id);

        $this->assertEquals($firstUser, $user);
    }

    public function test_find_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $id = 0;
        $repository = new UserRepository();
        $repository->find($id);
    }

    public function test_first(): void
    {
        $criteria = Query::eq('email', 'user.example1@email.com');
        $repository = new UserRepository();
        $user = $repository->first($criteria);

        $this->assertEquals('User 1', $user->name);

        $criteria = Query::lte('profile_id', 5);
        $users = User::where('profile_id', '<=', 5)->get();
        $repository = new UserRepository();
        $user = $repository->first($criteria);

        $this->assertEquals($users[0], $user);
    }

    public function test_first_not_found(): void
    {
        $criteria = Query::eq('email', 'not.found@email.com');
        $repository = new UserRepository();
        $user = $repository->first($criteria);

        $this->assertNull($user);
    }

    public function test_get(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();
        $users = $repository->get($criteria);

        $this->assertCount(5, $users);
        $this->assertLessThan($users[1]->id, $users[0]->id);

        $criteria = Query::lte('profile_id', 0);
        $repository = new UserRepository();
        $users = $repository->get($criteria);

        $this->assertIsIterable($users);
        $this->assertCount(1, $users);
    }

    public function test_get_users_when_not_found(): void
    {
        $criteria = Query::eq('profile_id', -1);
        $repository = new UserRepository();
        $users = $repository->get($criteria);

        $this->assertIsIterable($users);
        $this->assertCount(0, $users);
    }

    public function test_get_with_custom_order_by_and_sort(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();
        $users = $repository->get($criteria, sort: 'desc');

        $this->assertCount(5, $users);
        $this->assertGreaterThan($users[1]->id, $users[0]->id);

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

        $criteria = Query::like('email', 'alfabeto');
        $repository = new UserRepository();
        $users = $repository->get($criteria, order_by: 'name', sort: 'desc');

        $this->assertCount(2, $users);
        $this->assertEquals('C', $users[0]->name);
        $this->assertEquals('B', $users[1]->name);
    }

    public function test_paginate(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();
        $users = $repository->paginate($criteria, page: 1, per_page: 5, page_name: 'test');
        $this->assertCount(5, $users);
        $this->assertLessThan($users[1]->id, $users[0]->id);

        $users = $repository->paginate($criteria, page: 1, per_page: 5, page_name: 'test');
        $this->assertCount(5, $users);
        $this->assertLessThan($users[1]->id, $users[0]->id);

        $criteria = Query::lte('profile_id', 0);
        $users = $repository->paginate($criteria, page: 5, per_page: 1, page_name: 'test');

        $this->assertIsIterable($users);
        $this->assertCount(0, $users);
    }

    public function test_paginate_not_found(): void
    {
        $criteria = Query::eq('profile_id', -1);
        $repository = new UserRepository();
        $users = $repository->paginate($criteria, page: 1, per_page: 5, page_name: 'test');
        $this->assertCount(0, $users);
    }

    public function test_paginate_with_order_by_and_sort(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();
        $users = $repository->paginate($criteria, page: 1, per_page: 5, page_name: 'test', sort: 'desc');

        $this->assertCount(5, $users);
        $this->assertGreaterThan($users[1]->id, $users[0]->id);

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

        $criteria = Query::like('email', 'alfabeto');
        $repository = new UserRepository();
        $users = $repository->paginate($criteria, page: 1, per_page: 5, page_name: 'test', order_by: 'name', sort: 'desc');

        $this->assertCount(2, $users);
        $this->assertEquals('C', $users[0]->name);
        $this->assertEquals('B', $users[1]->name);
    }

    public function test_exists(): void
    {
        $criteria = Query::eq('name', 'User 0');
        $repository = new UserRepository();
        $isExists = $repository->exists($criteria);

        $this->assertEquals(true, $isExists);
    }

    public function test_exists_when_not_found(): void
    {
        $criteria = Query::eq('name', 'User Not Found');
        $repository = new UserRepository();
        $isExists = $repository->exists($criteria);

        $this->assertEquals(false, $isExists);
    }

    public function test_create(): void
    {
        $data = [
            'name' => 'User Test Create',
            'email' => 'user.test@email.com',
            'phone' => '556188888881',
            'password' => 'Bauhaus99',
            'profile_id' => 1,
        ];

        $repository = new UserRepository();
        $user = $repository->create($data);

        $this->assertModelExists($user);
        $this->assertEquals($data['name'], $user->name);
    }

    public function test_create_when_database_error(): void
    {
        $this->expectException(PDOException::class);
        $data = [
            'name' => 'User Test Create',
            'phone' => '556188888881',
            'password' => 'Bauhaus99',
            'profile_id' => 1,
        ];

        $repository = new UserRepository();
        $repository->create($data);
    }

    public function test_update(): void
    {
        $data = [
            'name' => 'User Test Create',
            'phone' => '556188888881',
            'email' => 'user.test@email.com',
            'password' => 'Bauhaus99',
            'profile_id' => 1,
        ];

        $repository = new UserRepository();
        $user = $repository->create($data);
        $criteria = Query::eq('id', $user->id);

        $repository->update($criteria, [
            'name' => 'User Test Updated',
        ]);

        $user->refresh();
        $this->assertEquals('User Test Updated', $user->name);
    }

    public function test_update_when_database_error(): void
    {
        $this->expectException(PDOException::class);
        $data = [
            'name' => 'User Test Create',
            'phone' => '556188888881',
            'email' => 'user.test@email.com',
            'password' => 'Bauhaus99',
            'profile_id' => 1,
        ];

        $repository = new UserRepository();
        $user = $repository->create($data);

        $criteria = Query::eq('id', $user->id);
        $repository->update($criteria, [
            'email' => null,
        ]);
    }

    public function test_update_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $repository = new UserRepository();
        $criteria = Query::eq('id', -1);
        $repository->update($criteria, [
            'email' => 'user.test@email.com',
        ]);
    }

    public function test_update_batch(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();

        $repository->updateBatch($criteria, [
            'profile_id' => 1,
        ]);

        $user = User::where('profile_id', '!=', 1)->first();
        $this->assertNull($user);
    }

    public function test_update_batch_when_database_error(): void
    {
        $this->expectException(PDOException::class);
        $criteria = Query::all();
        $repository = new UserRepository();

        $repository->updateBatch($criteria, [
            'email' => null,
        ]);
    }

    public function test_update_batch_when_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('profile_id', -1);
        $repository = new UserRepository();

        $repository->updateBatch($criteria, [
            'profile_id' => 1,
        ]);
    }

    public function test_delete_user(): void
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

    public function test_delete_batch_user(): void
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
        $user = User::where('email', 'user.example1@email.com')->first();
        $user->delete();

        $repository = new UserRepository();
        $criteria = Query::eq('email', 'notfound@email.com');
        $deletedUser = $repository->firstInTrash($criteria);
        $this->assertNull($deletedUser);
    }

    public function test_get_in_trash(): void
    {
        $criteria = Query::all();
        $repository = new UserRepository();
        $repository->deleteBatch($criteria);

        $deletedUsers = $repository->getInTrash($criteria);
        $this->assertCount(5, $deletedUsers);
        $this->assertLessThan($deletedUsers[1]->id, $deletedUsers[0]->id);

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

        $users = $repository->getInTrash($criteria, sort: 'desc');
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
        $this->assertLessThan($users[1]->id, $users[0]->id);

        $users = $repository->paginateInTrash($criteria, page: 1, per_page: 5, page_name: 'test');
        $this->assertCount(5, $users);
        $this->assertLessThan($users[1]->id, $users[0]->id);

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

        $users = $repository->paginateInTrash($criteria, page: 1, per_page: 5, page_name: 'test', sort: 'desc');
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
