<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = "coupon";

    public $timestamps = false;

    protected $primaryKey = "id";

    protected $fillable = ['code','start_date','start_date','type','value','created_at','updated_at','status'];    
}