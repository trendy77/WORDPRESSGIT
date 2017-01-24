<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Categories extends Model
{
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug_url', 'pos', 'bg_color', 'cat_img'];

}
