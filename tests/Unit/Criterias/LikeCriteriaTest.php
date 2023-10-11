<?php

namespace Tests\Unit\Criterias;

use App\Criterias\Common\LikeCriteria;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeCriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    /**
     * Like Criteria
     * Case: search by term
     */
    public function test_like_criteria(): void
    {

        $criteria = new LikeCriteria('email', '.example');
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertCount(5, $filtered_users);

        $criteria = new LikeCriteria('email', '.example1');
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertCount(1, $filtered_users);
        $this->assertTrue($filtered_users->contains('email', '=', 'user.example1@email.com'));
    }

    /**
     * Like Criteria
     * Case: value not found
     */
    public function test_equals_criteria_when_not_found(): void
    {
        $criteria = new LikeCriteria('email', '.example.nfound');
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertEmpty($filtered_users);
    }
}
