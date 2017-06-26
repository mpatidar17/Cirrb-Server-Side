<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{

    protected $table = "restaurants";

    protected $fillable = ['name','description','phone','email','image','approved','approved_on'];

    public function branches(){

     return $this->hasMany('App\Models\Branch');

    }

    public function menus(){

      return $this->hasMany('App\Models\Menu');

    }
}
