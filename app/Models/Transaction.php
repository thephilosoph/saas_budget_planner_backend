<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $hidden = ['tenant_id'];
    protected $guarded = ['tenant_id','id'];
}
