<?php

namespace Tests\Unit\Criterias;

use App\Criterias\Common\NotEqualCriteria;
use App\Models\User;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotEqualCriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function test_not_equals_criteria_with_integer_field(): void
    {

        $criteria = new NotEqualCriteria('profile_id', 1);
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertCount(4, $filtered_users);
        $this->assertTrue($filtered_users->contains('email', '!=', 'user.example1@email.com'));
    }

    public function test_not_equals_criteria_with_string_field(): void
    {
        $criteria = new NotEqualCriteria('email', 'user.example3@email.com');
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertCount(4, $filtered_users);
        $this->assertTrue($filtered_users->contains('profile_id', '!=', 3));
    }

    public function test_equals_criteria_when_not_found(): void
    {
        $criteria = new NotEqualCriteria('email', 'notfoundemail@email.com');
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertCount(5, $filtered_users);
    }
}
