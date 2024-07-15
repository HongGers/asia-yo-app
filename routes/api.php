<?php

use App\Http\Controllers\OrderController;

Route::group(['prefix' => 'orders'], function () {
    Route::post('/', [OrderController::class, 'create']);
});
