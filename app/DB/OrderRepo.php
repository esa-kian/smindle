<?php

namespace App\DB;

use App\Models\Order;

class OrderRepo
{
    public function save($order): Order
    {
        return Order::create([
            'first_name' => $order['first_name'],
            'last_name' => $order['last_name'],
            'address' => $order['address']
        ]);
    }
}
