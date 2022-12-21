<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth:sanctum', 'active'])->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user()->toArray();
        $user['permissions'] = $request->user()->getAllPermissions()->pluck('name');
        return $user;
    });
    Route::get('/authenticated', function () {
        return true;
    });

    Route::post('check-url', 'IfollowController@checkUrl');
});

Route::post('register', 'RegisterController@register');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout')->middleware('auth:sanctum');
Route::put('settings/profile', 'ProfileController@update')->middleware('auth:sanctum');
Route::put('settings/password', 'PasswordController@update')->middleware('auth:sanctum');
