<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function products()
    {
        return $this->hasMany('App\Product', 'category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id', 'id');
    }

    // public function children()
    // {
    //     return null !== $this->roles()->whereIn('name', $roles)->first();
    // }
}
