<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\UpdateBatchMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PDOException;
use Tests\TestCase;

class UpdateBatchMethodsTest extends TestCase
{
    use RefreshDatabase;
    use UpdateBatchMethods;

    protected function getModel(): Model
    {
        return new User();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function testUpdateBatch(): void
    {
        $criteria = Query::all();
        $this->updateBatch($criteria, [
            'profile_id' => 1,
        ]);

        $user = User::where('profile_id', '!=', 1)->first();
        $this->assertNull($user);
    }

    public function testUpdateBatchWhenDatabaseError(): void
    {
        $this->expectException(PDOException::class);

        $criteria = Query::all();
        $this->updateBatch($criteria, [
            'email' => null,
        ]);
    }

    public function testUpdateBatchWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('id', -1);
        $this->updateBatch($criteria, [
            'email' => 'user.test@email.com',
        ]);
    }
}
