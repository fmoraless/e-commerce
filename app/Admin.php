<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guard = 'admin';

    protected $fillable = [
      'name', 'email', 'type', 'password', 'image', 'status'
    ];
    protected $hidden = [
        'password', 'remember_token'
    ];
}
