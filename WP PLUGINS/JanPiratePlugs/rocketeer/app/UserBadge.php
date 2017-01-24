<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    protected $table = 'user_badge';

    protected $fillable = [ 'uid', 'bid' ];
}
