<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends BaseController
{
    function get() {
        $payment = PaymentMethod::all();
        return $this->sendResponse($payment);
    }

    function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:payment_methods',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $methods = new PaymentMethod();
        $methods->method = $request->name;
        $methods->save();

        return $this->sendResponse($methods);
    }

    function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:payment_methods',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $methods = PaymentMethod::whereId($request->id)->first();
        $methods->method = $request->name;
        $methods->update();

        return $this->sendResponse($methods);
    }

    function delete(Request $request)
    {
        $methods = PaymentMethod::whereId($request->id)->first();
        $methods->delete();

        return $this->sendResponse();
    }
}
