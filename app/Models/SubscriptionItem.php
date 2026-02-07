<?php

namespace App\Models;

use Laravel\Cashier\SubscriptionItem as CashierSubscriptionItem;

class SubscriptionItem extends CashierSubscriptionItem
{
    protected $hidden = ['stripe_id','stripe_product'];
}
