<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
}
