<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Frontend\SendMessageController;
use App\Http\Controllers\Admin\SendMessageController as SendMessageControllerAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("send-message",[SendMessageController::class,"store"]);

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [AuthController::class,'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get("messages",[SendMessageControllerAdmin::class,"index"]);
    });
  });