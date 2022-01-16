<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    public function orders()
    {
        return $this->hasMany('App\Order', 'customer_id', 'id');
    }

    public function shipping()
    {
        return $this->hasMany('App\Shipping','shipping_id', 'id');
    }
}
