<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'name', 'type', 'matp'
    ];
    protected $primaryKey = 'maqh';
    protected $table = 'tbl_quanhuyen';

    public function city()
    {
        return $this->belongsTo('App\City', 'matp', 'matp');
    }

    public function wards()
    {
        return $this->belongsTo('App\District', 'maqh', 'maqh');
    }
}
