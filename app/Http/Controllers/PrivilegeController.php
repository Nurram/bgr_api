<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrivilegeController extends BaseController
{
    function get() {
        $privileges = Privilege::all();
        return $this->sendResponse($privileges);
    }

    function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:privileges',
            'discountPercent' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $privilege = new Privilege();
        $privilege->name = $request->name;
        $privilege->discount_percent = $request->discountPercent;
        $privilege->save();

        return $this->sendResponse($privilege);
    }

    function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'discountPercent' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $privilege = Privilege::whereId($request->id)->first();
        $privilege->name = $request->name;
        $privilege->discount_percent = $request->discountPercent;
        $privilege->update();

        return $this->sendResponse($privilege);
    }

    function delete(Request $request)
    {
        $uoms = Privilege::whereId($request->id)->first();
        $uoms->delete();

        return $this->sendResponse();
    }
}
