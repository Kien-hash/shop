<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
