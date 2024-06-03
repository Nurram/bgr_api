<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
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
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            "code" => 200,
            "message" => "Sukses",
            "data" => $user,
            "token" => $token,
        ]);
    }

    function login(Request $request) 
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Invalid email / password', code: 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        $user->role = $user->role->name;
        return response()->json([
            "code" => 200,
            "message" => "Sukses",
            "data" => $user,
            "token" => $token,
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->sendResponse([], 'Sukses');
    }
}
