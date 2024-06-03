<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrivilegeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UomController;
use App\Http\Controllers\UserController;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/items', [ItemController::class, 'get']);
    Route::post('/items/insert', [ItemController::class, 'insert']);
    Route::post('/items/update', [ItemController::class, 'update']);
    Route::delete('/items/delete', [ItemController::class, 'delete']);
    Route::post('/items/search', [ItemController::class, 'search']);
    Route::post('/items/details', [ItemController::class, 'getItemDetails']);

    Route::get('/paymentMethod', [PaymentMethodController::class, 'get']);
    Route::post('/paymentMethod/insert', [PaymentMethodController::class, 'insert']);
    Route::post('/paymentMethod/update', [PaymentMethodController::class, 'update']);
    Route::delete('/paymentMethod/delete', [PaymentMethodController::class, 'delete']);
    
    Route::get('/uoms', [UomController::class, 'get']);
    Route::post('/uoms/insert', [UomController::class, 'insert']);
    Route::post('/uoms/update', [UomController::class, 'update']);
    Route::delete('/uoms/delete', [UomController::class, 'delete']);
    
    Route::get('/orders', [OrderController::class, 'get']);
    Route::post('/orders', [OrderController::class, 'getById']);
    Route::post('/orders/insert', [OrderController::class, 'insert']);

    Route::get('/privileges', [PrivilegeController::class, 'get']);
    Route::post('/privileges/insert', [PrivilegeController::class, 'insert']);
    Route::post('/privileges/update', [PrivilegeController::class, 'update']);
    Route::delete('/privileges/delete', [PrivilegeController::class, 'delete']);
    
    Route::get('/roles', [RoleController::class, 'get']);
    Route::post('/roles/insert', [RoleController::class, 'insert']);
    Route::post('/roles/update', [RoleController::class, 'update']);
    Route::delete('/roles/delete', [RoleController::class, 'delete']);
    
    Route::get('/permissions', [PermissionController::class, 'get']);
    Route::post('/permissions/insert', [PermissionController::class, 'insert']);
    Route::post('/permissions/update', [PermissionController::class, 'update']);
    Route::delete('/permissions/delete', [PermissionController::class, 'delete']);
   
    Route::post('/rolePermissions/getByRoleId', [RolePermissionController::class, 'getByRoleId']);
    Route::post('/rolePermissions/insert', [RolePermissionController::class, 'insert']);
    Route::post('/rolePermissions/update', [RolePermissionController::class, 'update']);
    Route::delete('/rolePermissions/delete', [RolePermissionController::class, 'delete']);

    Route::get('/users', [UserController::class, 'get']);
    Route::post('/users/insert', [UserController::class, 'insert']);
    Route::post('/users/update', [UserController::class, 'update']);
    Route::delete('/users/delete', [UserController::class, 'delete']);
});