<?php

use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\FundCallBack;
use App\Http\Controllers\Api\FundCallBackController;
use App\Http\Controllers\Api\TicketController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::any('/create/ticket', [TicketController::class, 'create']);
    Route::any('fund/callbacks/{route}', [FundCallBackController::class, 'callback']);
});



Route::group(['prefix' => 'api/callbacks/chat'], function () {
    Route::any('{api}', [CallbackController::class, 'callback']);
});
Route::group(['prefix' => 'api/callbacks/payment'], function () {
    Route::any('{api}', [CallbackController::class, 'callback']);
});

