<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaLikes extends Model
{
    protected $table = 'media_likes';

    protected $fillable = [ 'mid', 'sid' ];
}
