<?php

use App\Http\Controllers\API\V1\Account\ProfileController;
use App\Http\Controllers\API\V1\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register-user', [LoginController::class, 'create_member']);
        Route::post('/validate-credentials', [LoginController::class, 'Validate_credentials']);
    });
    Route::group(['middleware' => ['project.auth']], function () {
        Route::group(['prefix' => 'account'], function () {
            Route::post('/set-profile',[ProfileController::class, 'setProfile']);
        });
    });
    // Route::group(['middleware' => ['project.auth']], function () {
    //     Route::group(['prefix' => 'product'], function () {
    //         Route::get('/get-products', [ProductsController::class, 'getProduct']);

    //     });
    // });
});
