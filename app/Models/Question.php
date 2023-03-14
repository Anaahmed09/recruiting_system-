<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  protected $guarded = [];
  public $timestamps = true;
  use HasFactory;

  public function job()
  {
    return $this->belongsTo(Job::class);
  }
  
}
