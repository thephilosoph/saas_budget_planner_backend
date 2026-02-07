<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $guarded = ['stripe_price_id','id'];
    protected $hidden = ['stripe_price_id'];
}
