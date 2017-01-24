<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollVotes extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'poll_votes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'pid', 'vote_keys', 'sid' ];
}
