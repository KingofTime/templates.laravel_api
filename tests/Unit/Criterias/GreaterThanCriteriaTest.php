<?php

namespace Tests\Unit\Criterias;

use App\Criterias\Common\GreaterThanCriteria;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GreaterThanCriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    /**
     * Greater Than Criteria
     * Case: the field is integer type
     */
    public function test_greater_than_criteria_with_integer_field(): void
    {

        $criteria = new GreaterThanCriteria('profile_id', 2);
        $filtered_users = $criteria->apply(new User())->get();
        $filtered_profile_ids = $filtered_users
            ->map(fn (User $user) => $user->profile_id) //@phpstan-ignore-line
            ->toArray();

        $this->assertEquals([3, 4], $filtered_profile_ids);
        $this->assertCount(2, $filtered_users);
    }

    /**
     * Greater Than Criteria
     * Case: value not found
     */
    public function test_greater_than_criteria_when_not_found(): void
    {
        $criteria = new GreaterThanCriteria('profile_id', 1000);
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertEmpty($filtered_users);
    }
}
