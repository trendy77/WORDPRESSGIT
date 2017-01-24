<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $table = 'followers';

    protected $fillable = ['subscriber_uid', 'followed_uid'];

    public function subscriber(){
        return $this->hasOne( 'App\User', 'id', 'subscriber_uid' );
    }

    public function following(){
        return $this->hasOne( 'App\User', 'id', 'followed_uid' );
    }
}
