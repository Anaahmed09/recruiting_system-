<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'admin_id' => Admin::inRandomOrder()->first()->id,
      'title' => fake()->name(),
      'description' => fake()->text(),
      'start_date' => fake()->dateTimeBetween($startDate = "-60 days", $endDate = "-20 days")->format('Y-m-d'),
      'end_data' => fake()->dateTimeBetween($startDate = "-15 days", $endDate = "now")->format('Y-m-d'),
    ];
  }
}
