<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    function get()
    {
        $users = User::select('users.*', 'roles.name as roleName')
            ->join('roles', 'roles.id', '=', 'role_id')
            ->where('users.id', '!=', 1)
            ->get();

        return $this->sendResponse($users, 'Sukses');
    }
    function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->roleId
        ]);

        return $this->sendResponse();
    }

    function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = User::whereId($request->id)->first();
        $user->name = $request->name;
        $user->role_id = $request->role_id;
        // $user->email = $request->email;
        $user->save();
        return $this->sendResponse();
    }
}
