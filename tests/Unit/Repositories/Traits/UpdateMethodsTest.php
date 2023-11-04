<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\UpdateMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PDOException;
use Tests\TestCase;

class UpdateMethodsTest extends TestCase
{
    use RefreshDatabase;
    use UpdateMethods;

    protected function getModel(): Model
    {
        return new User();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function testUpdate(): void
    {
        $user = $this->getModel()::create([
            'name' => 'User Test Create',
            'email' => 'user.test@email.com',
            'password' => 'Bauhaus99',
            'profile_id' => 1,
        ]);

        $criteria = Query::eq('id', $user->id);
        $this->update($criteria, [
            'name' => 'User Test Updated',
        ]);

        $user->refresh();
        $this->assertEquals('User Test Updated', $user->name);
    }

    public function testUpdateWhenQueryReturnMultipleValues(): void
    {
        $criteria = Query::all();
        $this->update($criteria, [
            'name' => 'Jurassic Park',
        ]);

        $users = User::where('name', '=', 'Jurassic Park')->get();
        $this->assertCount(1, $users);
    }

    public function testUpdateWhenDatabaseError(): void
    {
        $this->expectException(PDOException::class);

        $user = $this->getModel()::create([
            'name' => 'User Test Create',
            'email' => 'user.test@email.com',
            'password' => 'Bauhaus99',
            'profile_id' => 1,
        ]);

        $criteria = Query::eq('id', $user->id);
        $this->update($criteria, [
            'email' => null,
        ]);
    }

    public function testUpdateWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('id', -1);
        $this->update($criteria, [
            'email' => 'user.test@email.com',
        ]);
    }
}
