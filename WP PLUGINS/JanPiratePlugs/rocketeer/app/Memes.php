<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memes extends Model
{
    protected $table = 'memes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['meme_name', 'upl_name', 'ext'];
}
