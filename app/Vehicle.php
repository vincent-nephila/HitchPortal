<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    
           public function trip(){
        return $this->hasMany('\App\Trip');
    } 
    
     
}