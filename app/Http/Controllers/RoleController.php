<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends BaseController
{
    function get()
    {
        $roles = Role::all();
        return $this->sendResponse($roles);
    }

    function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $roles = new Role();
        $roles->name = $request->name;
        $roles->save();

        $permisions = $request->permissions;
        $rolePermissions = [];

        foreach ($permisions as $permission) {
            $rolePermission =[
                'role_id' => $roles->id,
                'permission_id' => $permission['permissionId'],
                'is_active' => $permission['is_active']
            ];

            array_push($rolePermissions, $rolePermission);
        }

        RolePermission::insert($rolePermissions);
        return $this->sendResponse($roles);
    }

    function update(Request $request)
    {
        $permissions = $request->permissions;
        $allowedPermission = [];
        $notAllowedPermission = [];

        foreach ($permissions as $permission) {
            if ($permission['is_active']) {
                array_push($allowedPermission, $permission['permissionId']);
            } else {
                array_push($notAllowedPermission, $permission['permissionId']);
            }
        }

        RolePermission::where('role_id', $request->id)->whereIn('permission_id', $allowedPermission)->update(['is_active' => true]);
        RolePermission::where('role_id', $request->id)->whereIn('permission_id', $notAllowedPermission)->update(['is_active' => false]);

        $roles = Role::whereId($request->id)->first();
        $roles->name = $request->name;
        $roles->update();

        return $this->sendResponse();
    }

    function delete(Request $request)
    {
        $roles = Role::whereId($request->id)->first();
        $roles->delete();

        return $this->sendResponse();
    }
}
