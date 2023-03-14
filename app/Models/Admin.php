<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model implements Authenticatable
{
  use HasFactory, HasApiTokens;
  use AuthenticatableTrait;
  public function job()
  {
    return $this->hasMany(Job::class);
  }
}
