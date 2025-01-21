<?php

namespace App\DB;

use App\Models\Item;

class ItemRepo
{
    public function save($order, $item)
    {
        Item::create([
            'name' => $item['name'],
            'type' => $item['type'],
            'price' => $item['price'],
            'order_id' => $order->id
        ]);
    }
}
