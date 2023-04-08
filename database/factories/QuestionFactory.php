<?php

namespace Database\Factories;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public $num = 1;

  public function definition(): array
  {
   
    return [
      'title' => fake()->realText(),
      'description' => fake()->text(),
      'Answer1' => fake()->text(),
      'Answer2' => fake()->text(),
      'Answer3' => fake()->text(),
      'RightAnswer' => fake()->text(),
    ];
  }
}
