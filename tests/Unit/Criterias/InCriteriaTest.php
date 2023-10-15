<?php

namespace Tests\Unit\Criterias;

use App\Criterias\Common\InCriteria;
use App\Models\User;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InCriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function test_in_criteria_with_array_of_integers_field(): void
    {
        $criteria = new InCriteria('profile_id', [1, 2, 3]);
        $filtered_users = $criteria->apply(new User())->get();
        $filtered_profile_emails = $filtered_users
            ->map(fn (User $user) => $user->email) //@phpstan-ignore-line
            ->toArray();

        $this->assertEquals([
            'user.example1@email.com',
            'user.example2@email.com',
            'user.example3@email.com',
        ], $filtered_profile_emails);
        $this->assertCount(3, $filtered_users);
    }

    public function test_in_criteria_with_array_of_strings_field(): void
    {
        $criteria = new InCriteria('email', [
            'user.example1@email.com',
            'user.example2@email.com',
            'user.example3@email.com',
        ]);
        $filtered_users = $criteria->apply(new User())->get();
        $filtered_profile_ids = $filtered_users
            ->map(fn (User $user) => $user->profile_id) //@phpstan-ignore-line
            ->toArray();

        $this->assertEquals([1, 2, 3], $filtered_profile_ids);
        $this->assertCount(3, $filtered_users);
    }

    public function test_in_criteria_when_not_found(): void
    {
        $criteria = new InCriteria('profile_id', [1000]);
        $filtered_users = $criteria->apply(new User())->get();

        $this->assertEmpty($filtered_users);
    }
}
