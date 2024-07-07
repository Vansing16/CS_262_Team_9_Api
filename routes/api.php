<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\MessageApiController;
use App\Http\Controllers\API\AccountAPI;
use App\Http\Controllers\API\AdminManagement;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AccountAPI::class, 'login']);
Route::post('/logout', [AccountAPI::class, 'logout']);
Route::post('/Customer/acc', [AccountAPI::class, 'create']);

Route::group(['prefix' => 'Admin', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [AdminManagement::class, 'index']);
    Route::get('/ticket', [AdminManagement::class, 'allTicket']);
    Route::post('/', [AdminManagement::class, 'create']);
    Route::get('/show/{id}', [AdminManagement::class, 'showUser']);
    Route::post('/update', [AdminManagement::class, 'update']);
    Route::delete('/delete/{id}', [AdminManagement::class, 'destroyUser']);
    Route::delete('/delete/Ticket/{id}', [AdminManagement::class, 'destroyTicket']);
    Route::get('/show/Ticket/{id}', [AdminManagement::class, 'showTicket']);
    Route::post('/assign', [AdminManagement::class, 'assignTicket']);
    Route::get('/viewfeedback/{id}', [AdminManagement::class, 'viewFeedback']);
    Route::get('/Message', [MessageApiController::class, 'viewMessage']);
});
Route::group(['prefix' => 'Customer', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [CustomerApiController::class, 'create']);
    Route::get('/show/{id}', [AccountAPI::class, 'showUser']);
    Route::post('/sendMessage', [MessageApiController::class, 'sendMessage']);
    Route::get('/Message', [MessageApiController::class, 'viewMessage']);
    Route::get('/show/ticket/{id}', [CustomerApiController::class, 'show']);
    Route::post('/updateAcc', [AccountAPI::class, 'update']);
    Route::post('/feedback', [CustomerApiController::class, 'feedback']);
});
Route::group(['prefix' => 'Technician', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/show/{id}', [AccountAPI::class, 'showUser']);
    Route::get('/Message', [MessageApiController::class, 'viewMessage']);
    Route::post('/CreateMessage', [MessageApiController::class, 'MakeMessage']);
    Route::post('/update', [AccountAPI::class, 'update']);
    Route::get('/show/Ticket/{id}', [CustomerApiController::class, 'show']);
    Route::post('/status', [MessageApiController::class, 'updateStatus']);
});




