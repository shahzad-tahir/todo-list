<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoItemController;
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

//public routes
Route::post('login', AuthController::class);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('/todo-items', TodoItemController::class)->except('show');
    Route::prefix('todo-items')
        ->group(function () {
            Route::get('change-status/{todoItem}', [TodoItemController::class, 'changeStatus']);
        });
});
