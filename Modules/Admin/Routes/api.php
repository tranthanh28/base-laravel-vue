<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use Modules\Admin\Http\Controllers\RoleController;
//use Modules\Admin\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->prefix("/admin")->group(function () {
    Route::post('check-url', 'IfollowController@checkUrl');
    Route::resource('roles', RoleController::class)->only(['index', 'update']);
    Route::resource('users', UserController::class)->only(['index', 'update', 'store', 'destroy']);
});
