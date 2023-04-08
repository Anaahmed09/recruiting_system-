<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
  use HasFactory;
  protected $guarded=[];
  protected $perPage = 5;
  public function admin()
  {
    return $this->belongsTo(Admin::class);
  }
  public function question()
  {
    return $this->hasMany(Question::class);
  }
  public function user()
  {
    // from job_user
    return $this->belongsToMany(User::class)->withPivot('numbers_of_wrong_answers', 'numbers_of_right_answers', 'status');
  }


}
