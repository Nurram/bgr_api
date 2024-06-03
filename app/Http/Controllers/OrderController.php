<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderLines;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    function get() {
        $orders = Order::all();
        return $this->sendResponse($orders);
    }

    function getById(Request $request) {
        $order = Order::select('orders.*', 'payment_methods.method as paymentMethod', 'privileges.discount_percent')
        ->join('payment_methods', 'payment_methods.id', '=', 'orders.payment_id')
        ->join('privileges', 'privileges.id', '=', 'orders.privilege_id')
        ->where('orders.id', '=', $request->id)
        ->first();

        if($order) {
            $orderLines = OrderLines::select('order_lines.qty', 'items.name as itemName', 'items.price as itemPrice', 'unit_of_materials.name as uom')
            ->where('order_id', '=', $order->id)
            ->join('items', 'items.id', '=', 'order_lines.item_id')
            ->join('unit_of_materials', 'unit_of_materials.id', '=', 'items.uom_id')
            ->get();

            $order['orderLines'] = $orderLines;
        }

        return $this->sendResponse($order);
    }

    function insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $itemIds = [];
        foreach ($request->items as $item) {
            array_push($itemIds, $item['id']);
        }

        $itemController = new ItemController();
        $items = $itemController->getItems($itemIds);

        foreach ($items as $item) {
            foreach ($request->items as $item2) {
                if($item->id == $item2['id']) {
                    if($item->stock < $item2['qty']) {
                        return $this->sendError('Stok '. $item->name . ' tidak cukup!', code: 500);
                    }

                    break;
                }
            }
        }

        $order = new Order();
        $order->user_id = $request->userId;
        $order->receiver_name = $request->receiverName;
        $order->receiver_address = $request->receiverAddress;
        $order->receiver_phone = $request->receiverPhone;
        $order->payment_id = $request->paymentId;
        $order->price = $request->price;
        $order->price_after_tax = $request->priceAfterTax;
        $order->privilege_id = $request->privilegeId;
        $order->save();

        $currentDate = Carbon::now();
        $invoice = 'INV/' . $this->numberToRomanRepresentation($currentDate->month) . '/' . $currentDate->year . '/' . str_pad((string) $order->id, 3, '0', STR_PAD_LEFT);
 
        Order::whereId($order->id)->update([
            'invoice' => $invoice
        ]);
        $order->invoice = $invoice;

        $lineController = new OrderLineController();
        $lineController->insert($request->items, $order->id);

        return $this->sendResponse($order);
    }

    function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
