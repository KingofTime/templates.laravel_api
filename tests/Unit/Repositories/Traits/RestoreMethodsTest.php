<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\RestoreMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestoreMethodsTest extends TestCase
{
    use RefreshDatabase;
    use RestoreMethods;

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

    public function testRestore(): void
    {
        $criteria = Query::eq('email', 'user.example1@email.com');
        $this->restore($criteria);

        $users = $criteria->apply($this->getModel())->get();
        $this->assertCount(1, $users);
    }

    public function testRestoreWhenNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $criteria = Query::eq('profile_id', -1);
        $this->restore($criteria);
    }
}
