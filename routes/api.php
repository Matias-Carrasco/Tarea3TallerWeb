<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PerroController;
use \App\Http\Controllers\InteraccionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/perros/random', [PerroController::class, 'random']);
Route::post('/cambiarInteraccion', [InteraccionController::class, 'cambiarInteraccion']);

Route::resource('perros',PerroController::class);
Route::resource('interaccions',InteraccionController::class);
