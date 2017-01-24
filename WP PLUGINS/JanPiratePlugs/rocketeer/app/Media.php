<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'media_desc', 'content', 'media_type', 'thumbnail', 'featured_img', 'share_img', 'uid', 'cid',
        'slug_url', 'like_count', 'comment_count', 'status', 'page_content', 'page_content_filtered', 'weekly_like_count',
        'nsfw', 'uploads'
    ];

    public function author(){
        return $this->hasOne( 'App\User', 'id', 'uid' );
    }

    public function cat(){
        return $this->hasOne( 'App\Categories', 'id', 'cid' );
    }
}
