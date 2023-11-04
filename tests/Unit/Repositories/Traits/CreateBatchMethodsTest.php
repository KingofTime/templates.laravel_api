<?php

namespace Tests\Unit\Repositories\Traits;

use App\Models\User;
use App\Repositories\Base\Traits\CreateBatchMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PDOException;
use Tests\TestCase;

class CreateBatchMethodsTest extends TestCase
{
    use CreateBatchMethods;
    use RefreshDatabase;

    protected function getModel(): Model
    {
        return new User();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function testCreateBatch(): void
    {
        $data = [
            [
                'name' => 'User Test Create',
                'email' => 'user.test.create@email.com',
                'password' => 'Bauhaus99',
                'profile_id' => 1,
            ],
            [
                'name' => 'User Test Create 2',
                'email' => 'user.test.create2@email.com',
                'password' => 'Bauhaus101',
                'profile_id' => 1,
            ],
        ];

        $this->createBatch($data);

        $users = $this->getModel()::where('email', 'like', 'user.test.create%')->get();
        $this->assertCount(2, $users);

    }

    public function testCreateBatchWhenDatabaseError(): void
    {
        $this->expectException(PDOException::class);

        $data = [
            [
                'name' => 'User Test Create',
                'phone' => '556188888881',
                'password' => 'Bauhaus99',
                'profile_id' => 1,
            ],
            [
                'name' => 'User Test Create 2',
                'email' => 'user.test.create2@email.com',
                'password' => 'Bauhaus101',
                'profile_id' => 1,
            ],
        ];

        $this->createBatch($data);
    }
}
