<?php

namespace Tests\Unit\Repositories\Traits;

use App\Criterias\Common\Query;
use App\Models\User;
use App\Repositories\Base\Traits\AggregationMethods;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AggregateMethodsTest extends TestCase
{
    use AggregationMethods;
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

    public function testMax(): void
    {
        $criteria = Query::all();
        $maxProfile = $this->max($criteria, 'profile_id');

        $this->assertEquals(4, $maxProfile);
    }
}
