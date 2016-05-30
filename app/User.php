<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    public function trip(){
        return $this->hasMany('\App\Trip','idno');
    }
    public function vehicle(){
        return $this->hasMany('\App\Vehicle','idno');
    }      
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','middlename','lastname', 'email','password','mobile','address','accesslevel','status','confirmation_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','accesslevel','status','confirmation_code',
    ];
}
