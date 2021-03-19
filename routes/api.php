<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CollectionController;
use App\Http\Controllers\API\TrailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\DeleteFavoriteController;
use App\Http\Controllers\FavoritesController;

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

Route::middleware('auth:api')->get('index', function () {
    return ['Status' => 'Logged!'];
});

Route::resource('/collection', CollectionController::class);
Route::resource('/trail', TrailController::class);
Route::resource('/user', UserController::class);
Route::resource('/home', HomeController::class);
Route::resource('/article', ArticleController::class);
Route::resource('/classification', ClassificationController::class);
Route::resource('/favorite', FavoritesController::class);
Route::post('/favorite/delete', [FavoriteController::class, 'delete']);
