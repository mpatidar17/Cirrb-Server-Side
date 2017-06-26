<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = "branches";

    public function restaurants(){

     return $this->belongsTo('App\Models\Restaurant');

    }
}
