<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'name', 'type', 'maqh'
    ];
    protected $primaryKey = 'xaid';
    protected $table = 'tbl_xaphuongthitran';

    public function district()
    {
        return $this->belongsTo('App\District', 'maqh', 'maqh');
    }
}
