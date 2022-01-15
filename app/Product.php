<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function order_details()
    {
        return $this->belongsTo('App\OrderDetail', 'product_id', 'id');
    }
}
