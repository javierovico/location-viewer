<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\AuthMiddleware;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('login',[LoginController::class,'login']);
        Route::middleware(AuthMiddleware::class)->group(function(){
            Route::get('user',[LoginController::class,'getUser']);
        });
    });
    Route::prefix('usuario')->group(function(){
        Route::prefix('{Usuario}')->group(function(){       //TODO: aplicar algun Middleware que garantice que el usuario que accede es el duenho
            Route::prefix('subordinado')->group(function(){
                Route::get('',[UsuarioController::class,'getSubordinados']);
            });
        });
    });
});
