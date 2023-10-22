<?php

namespace Tests\Unit\Criterias;

use App\Criterias\Common\AllCriteria;
use App\Models\User;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllCriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function test_all_criteria(): void
    {

        $criteria = new AllCriteria();
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertCount(5, $filtered_users);
    }
}
