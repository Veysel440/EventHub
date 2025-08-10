<?php

namespace App\Models;

use App\Shared\Concerns\BelongsToTenant;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, BelongsToTenant;
    protected $fillable = ['tenant_id','name','email','password'];
    protected $hidden = ['password','remember_token'];
}
