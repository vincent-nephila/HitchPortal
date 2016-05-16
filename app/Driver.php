<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function trip()
    {
        return $this->hasOne('App\Trip','driver_id');
    }
}
