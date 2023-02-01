<?php

namespace App\Services;

use App\Models\Order;

class ApiDbMaster
{
    public function pushToDb(array $orderData, array $orderItems, int $scores)
    {
        $order = Order::find($orderData['id']) ?? Order::create($orderData);

        foreach ($order->items as $item) {
            $item->delete();
        }

        foreach ($orderItems as $item) {
            $order->items()->create($item);
        }

        $order->update(compact('scores'));
    }
}
