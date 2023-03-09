<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('questions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('job_id')->constrained();
      $table->string('title');
      $table->string('description')->nullable();
      $table->string('Answer1');
      $table->string('Answer2');
      $table->string('Answer3');
      $table->string('RightAnswer');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('questions');
  }
};
