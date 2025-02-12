<?php

use App\Enums\DiscussionType;
use App\Http\Controllers\DiscussionController;
use Illuminate\Support\Facades\Route;

Route::prefix('discussions')->group(function () {
   Route::get('/{type?}', [DiscussionController::class, 'index']);

});
