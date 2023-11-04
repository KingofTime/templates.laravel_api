<?php

namespace Tests\Unit\Repositories\Traits;

use App\Models\User;
use App\Repositories\Base\Traits\CreateMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PDOException;
use Tests\TestCase;

class CreateMethodsTest extends TestCase
{
    use CreateMethods;
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

    public function testCreate(): void
    {
        $data = [
            'name' => 'User Test Create',
            'email' => 'user.test.create@email.com',
            'password' => 'Bauhaus99',
            'profile_id' => 1,
        ];

        $user = $this->create($data);

        $this->assertModelExists($user);
        $this->assertEquals($data['name'], $user->name);
    }

    public function testCreateWhenDatabaseError(): void
    {
        $this->expectException(PDOException::class);
        $data = [
            'name' => 'User Test Create',
            'phone' => '556188888881',
            'password' => 'Bauhaus99',
            'profile_id' => 1,
        ];

        $this->create($data);
    }
}
