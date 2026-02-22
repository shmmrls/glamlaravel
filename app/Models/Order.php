<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $table = 'orders';
    protected $fillable = [
        'transaction_id', 'customer_id', 'payment_method',
        'shipping_fee', 'payment_status', 'order_status',
        'date_shipped',
    ];
}
