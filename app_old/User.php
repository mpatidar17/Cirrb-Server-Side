<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display','name','last_name', 'email', 'password','device_token','device_type','lat','long','auth_token','order_limit','phone','balance','status','roles','image','verified','verification_token','partner_status','approve','cash_in_hand',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function order(){

        return $this->hasMany('App\Models\Order');

    }

    public function orderOne(){

        return $this->hasOne('App\Models\Order');

    }

    public function partnerOrder(){

        return $this->hasMany('App\Models\Order','partner_id','id');

    }

    public function orderList(){


        return $this->hasManyThrough('App\Models\OrderList','App\Models\Order');

    }
    public function partnerResponse(){


        return $this->hasOne('App\Models\PartnerResponse','partner_id','id');

    }
}
