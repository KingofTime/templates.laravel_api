<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\RemoveMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveMethodsTest extends TestCase
{
    use RefreshDatabase;
    use RemoveMethods;

    protected function getModel(): Model
    {
        return new User();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function testRemove(): void
    {
        $criteria = Query::eq('email', 'user.example1@email.com');
        $this->remove($criteria);

        $user = User::where('email', 'user.example1@email.com')->first();
        $this->assertNull($user);
    }

    public function testRemoveWhenQueryReturnMultipleValues(): void
    {
        $criteria = Query::all();
        $this->remove($criteria);

        $users = User::all();
        $this->assertCount(4, $users);
    }

    public function testRemoveWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('email', 'not.found@email.com');
        $this->remove($criteria);
    }
}
