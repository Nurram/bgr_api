<?php

namespace App\Http\Controllers;

use App\Models\OrderLines;

class OrderLineController extends Controller
{
    function insert(array $items, int $orderId) {
        $lines = [];

        foreach ($items as $item) {
            $line = [
                'order_id' => $orderId,
                'item_id' => $item['id'],
                'qty' => $item['qty']
            ];

            array_push($lines, $line);
            
            $itemController = new ItemController();
            $itemController->reduceStock($item['id'], $item['qty']);
        }

        OrderLines::insert($lines);
    }
}
