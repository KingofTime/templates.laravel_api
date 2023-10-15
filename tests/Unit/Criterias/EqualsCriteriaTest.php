<?php

namespace Tests\Unit\Criterias;

use App\Criterias\Common\EqualsCriteria;
use App\Models\User;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EqualsCriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    /**
     * Equals Criteria
     * Case: the field is integer type
     */
    public function test_equals_criteria_with_integer_field(): void
    {

        $criteria = new EqualsCriteria('profile_id', 1);
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertCount(1, $filtered_users);
        $this->assertTrue($filtered_users->contains('email', '=', 'user.example1@email.com'));
    }

    /**
     * Equals Criteria
     * Case: the field is string type
     */
    public function test_equals_criteria_with_string_field(): void
    {
        $criteria = new EqualsCriteria('email', 'user.example3@email.com');
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertCount(1, $filtered_users);
        $this->assertTrue($filtered_users->contains('profile_id', '=', 3));
    }

    /**
     * Equals Criteria
     * Case: value not found
     */
    public function test_equals_criteria_when_not_found(): void
    {
        $criteria = new EqualsCriteria('email', 'notfoundemail@email.com');
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertEmpty($filtered_users);
    }
}
