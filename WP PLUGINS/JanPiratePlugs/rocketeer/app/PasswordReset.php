<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    protected $fillable = [ 'email', 'token' ];

    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }
}
