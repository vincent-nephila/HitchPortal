<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ctrRoute extends Model
{
    //
    function trip()
{
    
    return $this->hasMany('App\Trip','route');
}
}
