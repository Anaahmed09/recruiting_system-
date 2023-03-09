<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    for ($j = 1; $j <= 20; $j++) {
      for ($i = 0; $i < 20; $i++) {
        Question::factory()->count(1)->create(['job_id' => $j]);
      }
    }
  }
}
