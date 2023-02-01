<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiUpdateRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\ScoresCalculator;

class ApiController extends Controller
{
    public function update(ApiUpdateRequest $request)
    {
        $scores = (new ScoresCalculator())->getScores($request->items);

        $order = Order::find($request->id);

        if ($order) {
            foreach ($order->items as $item) {
                $item->delete();
            }
        } else {
            $order = Order::create($request->only('id', 'client_id', 'status'));
        }

        foreach ($request->items as $item) {
            $order->items()->create($item);
        }

        $order->update(compact('scores'));
    }
}
