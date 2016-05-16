<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //
        public function driver()
    {
        return $this->belongsTo('App\Driver');
    }
    
        public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }
    
        public function ctrRoute()
    {
        return $this->belongsTo('App\ctrRoute');
    }    
}
