<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\DishController;
use App\Http\Controllers\API\FloorController;
use App\Http\Controllers\API\KitchenController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\UserController;
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

// ---- API AUTHENTICATION ----
Route::group([

    'middleware' => ['api'],
    'prefix' => 'auth',

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

});

// ---- API USER ----
Route::group([
    'middleware' => ['api'],
    'prefix' => 'users',
], function () {
    Route::get('profile', [UserController::class, 'profile']);
});

Route::patch('/user/{id}', [UserController::class, 'update']);

// ---- API CATERORIES ----
Route::get('/categories', [CategoriesController::class, 'index']);
// ---- API DISH ----
Route::get('/dishs', [DishController::class, 'index']);
Route::get('/dish/category', [DishController::class, 'getListDishWithCategory']);
// ---- API FLOOR ----
Route::get('/floor', [FloorController::class, 'index']);
// ---- API FLOOR ----
Route::get('/table', [TableController::class, 'getListTableWithFloor']);
Route::post('/table/order', [TableController::class, 'orderTable']);
// ---- API ORDER ----
Route::post('/order', [OrderController::class, 'orderDish']);
Route::get('/order', [OrderController::class, 'getOrder']);
Route::patch('/order/accept', [OrderController::class, 'handleAcceptDish']);
// ---- API KITCHEN ----
Route::get('/dish/order', [KitchenController::class, 'getOrderDish']);
Route::patch('/dish/order/cooking', [KitchenController::class, 'handleDishCooking']);
Route::patch('/dish/order/done', [KitchenController::class, 'handleDishDone']);
// --- API BILLS ----
Route::post('/order/total', [OrderController::class, 'handleTotalPrice']);