<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaPoints extends Model
{
    protected $table = 'media_points';

    protected $fillable = [ 'uid', 'mid' ];
}
