<?php

use App\Http\Controllers\DocumentController;
use App\Enums\DiscussionType;
use App\Http\Controllers\DiscussionController;
use Illuminate\Support\Facades\Route;

Route::resource('discussions', DiscussionController::class);
Route::prefix('documents')->group(function () {
    Route::get('/', [DocumentController::class, 'index']);
    Route::post('/', [DocumentController::class, 'store']);
});
