<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends BaseController
{
    function get()
    {
        $permmissions = Permission::all();
        return $this->sendResponse($permmissions);
    }

    function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $permmissions = new Permission();
        $permmissions->name = $request->name;
        $permmissions->save();

        $roles = Role::all();
        $rolePermissions = [];

        foreach ($roles as $role) {
            $rolePermission = [
                'role_id' => $role->id,
                'permission_id' => $permmissions->id,
                'is_active' => false
            ];

            array_push($rolePermissions, $rolePermission);
        }

        RolePermission::insert($rolePermissions);
        return $this->sendResponse($permmissions);
    }

    function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $permmissions = Permission::whereId($request->id)->first();
        $permmissions->name = $request->name;
        $permmissions->update();

        return $this->sendResponse($permmissions);
    }

    function delete(Request $request)
    {
        $permmissions = Permission::whereId($request->id)->first();
        $permmissions->delete();

        return $this->sendResponse();
    }
}
