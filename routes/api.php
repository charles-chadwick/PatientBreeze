<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::prefix('documents')->group(function () {
    Route::get('/', [DocumentController::class, 'index']);
    Route::post('/', [DocumentController::class, 'store']);
});
