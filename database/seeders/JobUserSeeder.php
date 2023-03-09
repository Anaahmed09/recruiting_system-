<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobUserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    for ($i = 0; $i < 40; $i++) {
      $num = fake()->numberBetween(1, 20);
      $job = Job::inRandomOrder()->get()->first();
      $user = User::inRandomOrder()->get()->first();
      $job->user()->attach($user, [
        'numbers_of_wrong_answers' => $num,
        'numbers_of_right_answers' => 20 - $num, 'updated_at' => now(), 'created_at' => now()
      ]);
    }
  }
}
