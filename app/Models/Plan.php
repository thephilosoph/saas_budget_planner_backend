<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $guarded = ['stripe_price_id','id'];
    protected $hidden = ['stripe_price_id'];


    protected $casts = [
        'features' => 'array',
        'limits'   => 'array',
    ];

    public function getLimit(string $key): ?int
    {
        return $this->limits[$key] ?? null;
    }

    public function hasFeature(string $feature): bool
    {
        return (bool)($this->features[$feature] ?? false);
    }
}
