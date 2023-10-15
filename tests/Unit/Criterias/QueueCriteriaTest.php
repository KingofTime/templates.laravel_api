<?php

namespace Tests\Unit\Criterias;

use App\Criterias\Common\GreaterThanEqualCriteria;
use App\Criterias\Common\LessThanCriteria;
use App\Criterias\Common\LessThanEqualCriteria;
use App\Criterias\Common\NotEqualCriteria;
use App\Criterias\Common\QueueCriteria;
use App\Models\User;
use Database\Seeders\GenericTestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QueueCriteriaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(GenericTestSeeder::class);
    }

    public function test_queue_criteria(): void
    {
        $criteria = new QueueCriteria([
            new LessThanCriteria('profile_id', 4),
            new GreaterThanEqualCriteria('profile_id', 2),
        ]);

        $filtered_users = $criteria->apply(new User())->get();
        $filtered_profile_ids = $filtered_users
            ->map(fn (User $user) => $user->profile_id) //@phpstan-ignore-line
            ->toArray();

        $this->assertEquals([2, 3], $filtered_profile_ids);
        $this->assertCount(2, $filtered_users);
    }

    public function test_append_criteria(): void
    {
        $criteria = new QueueCriteria([
            new NotEqualCriteria('profile_id', 1),
        ]);

        $criteria->append(new LessThanEqualCriteria('profile_id', 3));
        $filtered_users = $criteria->apply(new User())->get();
        $filtered_profile_ids = $filtered_users
            ->map(fn (User $user) => $user->profile_id) //@phpstan-ignore-line
            ->toArray();

        $this->assertEquals([0, 2, 3], $filtered_profile_ids);
        $this->assertCount(3, $filtered_users);
    }

    public function test_queue_criteria_when_not_found(): void
    {
        $criteria = new QueueCriteria([
            new GreaterThanEqualCriteria('profile_id', 4),
            new LessThanCriteria('profile_id', 2),
        ]);

        $filtered_users = $criteria->apply(new User())->get();
        $this->assertEmpty($filtered_users);
    }
}
