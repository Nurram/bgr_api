<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends BaseController
{
    function get()
    {
        $items = Item::all();
        return $this->sendResponse($items, 'Sukses');
    }

    function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'required|integer|unique:items',
            'stock' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $item = new Item();
        $item->name = $request->name;
        $item->sku = $request->sku;
        $item->stock = $request->stock;
        $item->uom_id = $request->uomId;
        $item->price = $request->price;
        $item->save();

        return $this->sendResponse([], 'Sukses');
    }

    function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'required|integer',
            'stock' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $item = Item::whereId($request->id)->first();
        $item->name = $request->name;
        $item->stock = $request->stock;
        $item->uom_id = $request->uomId;
        $item->update();
        
        return $this->sendResponse([], 'Sukses');
    }

    function delete(Request $request)
    {
        Item::whereId($request->id)->delete();
        return $this->sendResponse([], 'Sukses');
    }

    function search(Request $request)
    {
        $items = Item::where('name', 'like', '%' . $request->name . '%')
            ->orderBy('stock', 'desc')
            ->get();

        foreach ($items as $item) {
            $item->uom;
        }

        return $this->sendResponse($items);
    }

    function getItemDetails(Request $request)
    {
        $items = Item::whereIn('id', $request->itemIds)->get();

        foreach ($items as $item) {
            $item->uom;
        }

        return $this->sendResponse($items);
    }

    function getItems(array $itemIds)
    {
        $items = Item::whereIn('id', $itemIds)->get();
        return $items;
    }

    function reduceStock($id, $qty)
    {
        Item::whereId($id)->decrement('stock', $qty);
    }
}
