<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';

    public function city()
    {
        return $this->belongsTo('App\City', 'matp', 'matp');
    }

    public function district()
    {
        return $this->belongsTo('App\District', 'maqh', 'maqh');
    }

    public function ward()
    {
        return $this->belongsTo('App\Ward', 'xaid', 'xaid');
    }
}
