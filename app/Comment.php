<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id', 'id');
    }
}
