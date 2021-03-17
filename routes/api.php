<?php

use App\Http\Controllers\API\CollectionController;
use App\Http\Controllers\API\TrailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PassportAuthController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('incorrectToken', function () {
    return response(['Status' => 'incorrect token!'], 401);
})->name('incorrectToken');

Route::post('register', [PassportAuthController::class, 'register']);
Route::middleware('auth:api')->post('profile', [PassportAuthController::class, 'createProfile']);

Route::post('login', [PassportAuthController::class, 'login']);

Route::post('/password/forget', [PassportAuthController::class, 'forgetPassword']);
Route::post('/password/confirm', [PassportAuthController::class, 'confirmVerificationCodes']);
Route::middleware('auth:api')->post('/password/change', [PassportAuthController::class, 'changePassword']);

Route::middleware('auth:api')->get('index', function () {
    return ['Status' => 'Logged!'];
});

Route::resource('/collection',CollectionController::class);
Route::resource('/trail',TrailController::class);

