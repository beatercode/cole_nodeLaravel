<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $table = 'login_attempts';

    protected $guarded = [];
}
