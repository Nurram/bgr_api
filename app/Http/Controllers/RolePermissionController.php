<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends BaseController
{
    function getByRoleId(Request $request)
    {
        $permissions = RolePermission::select('permissions.id as permissionId', 'permissions.name', 'role_permissions.is_active')
        ->join('permissions', 'permissions.id', '=', 'permission_id')
        ->where('role_permissions.role_id', '=', $request->roleId)
        ->get();
        
        return $this->sendResponse($permissions);
    }

    function insert(Request $request)
    {
        $permissions = new RolePermission();
        $permissions->name = $request->name;
        $permissions->save();

        return $this->sendResponse($permissions);
    }

    function update(Request $request)
    {
        $permissions = RolePermission::whereId($request->id)->first();
        $permissions->name = $request->name;
        $permissions->update();

        return $this->sendResponse($permissions);
    }

    function delete(Request $request)
    {
        $permissions = RolePermission::whereId($request->id)->first();
        $permissions->delete();

        return $this->sendResponse();
    }
}
