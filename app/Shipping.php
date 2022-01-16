<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shippings';

    public function orders()
    {
        return $this->hasMany('App\Order', 'shipping_id', 'id');
    }
}
