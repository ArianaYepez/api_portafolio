<?php

use App\Http\Controllers\Api\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(MessageController::class)->group(function (){
    Route::get('/messages', 'index');
    Route::post('/message', 'store');
    Route::get('/message/{id}', 'show');
    Route::put('/messages/{id}', 'update');
    Route::delete('/messages/{id}', 'destroy');
    //TODO: Cambiar a controlador de acceso
    Route::post('/login', 'login');
});
