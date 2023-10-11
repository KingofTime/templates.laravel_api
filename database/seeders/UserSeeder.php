<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)
            ->sequence(fn (Sequence $sequence) => [
                'name' => "User {$sequence->index}",
                'email' => "user.example{$sequence->index}@email.com",
                'profile_id' => $sequence->index,
            ])
            ->create();
    }
}
