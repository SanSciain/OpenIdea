<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\TagController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/ideaownedindex', [IdeaController::class, 'indexOwned']);
    // Route::get('/ideacreate', [IdeaController::class, 'create']);
    Route::post('/ideastore', [IdeaController::class, 'store']);
    Route::get('/ideaownedshow/{id}', [IdeaController::class, 'showOwned']);
    Route::get('/tagindex', [TagController::class, 'index']);
});


// Route::post('/register', 'AuthController@register')->name('auth.register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/ideaindex', [IdeaController::class, 'index']);
Route::get('/ideashow/{id}', [IdeaController::class, 'show']);
