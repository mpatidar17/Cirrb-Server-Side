<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    public $timestamps = false;

    protected $primaryKey = "id";

    /*protected $fillable = ['user_id','restaurant_id','branch_id','status'];*/

    public function order_list(){
  		return $this->hasMany('App\Models\OrderList','order_id','id');
    }
    public function restaurant(){

    	return $this->belongsTo('App\Models\Restaurant');

    }
    public function branch(){

    	return $this->belongsTo('App\Models\Branch');

    }
    public function user(){

        return $this->belongsTo('App\User');

    }
    public function partner(){

        return $this->belongsTo('App\User','partner_id','id');

    }
}