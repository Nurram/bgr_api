<?php

namespace App\Http\Controllers;

use App\Models\UnitOfMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UomController extends BaseController
{
    function get()
    {
        $uoms = UnitOfMaterial::all();
        return $this->sendResponse($uoms);
    }

    function insert(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:unit_of_materials',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $uoms = new UnitOfMaterial();
        $uoms->name = $request->name;
        $uoms->save();

        return $this->sendResponse($uoms);
    }
    
    function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:unit_of_materials',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $uoms = UnitOfMaterial::whereId($request->id)->first();
        $uoms->name = $request->name;
        $uoms->update();

        return $this->sendResponse($uoms);
    }

    function delete(Request $request) {
        $uoms = UnitOfMaterial::whereId($request->id)->first();
        $uoms->delete();

        return $this->sendResponse();
    }
}
