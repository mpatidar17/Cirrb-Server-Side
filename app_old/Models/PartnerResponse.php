<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerResponse extends Model
{
    protected $table = "partner_response";

    protected $fillable = ['order_id','partner_id','response'];
}
