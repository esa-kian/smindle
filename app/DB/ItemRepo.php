<?php

namespace App\DB;

use App\Models\Item;

class ItemRepo
{
    public function save($order, $basket)
    {
        if ($basket) {
            foreach ($basket as $item) {
                Item::create([
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'price' => $item['price'],
                    'order_id' => $order->id
                ]);
            }
        }
    }
}
