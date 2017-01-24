<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserUploads extends Model
{
    protected $table = 'user_uploads';

    protected $fillable = [
        'uid', 'original_name', 'upl_name'
    ];
}
