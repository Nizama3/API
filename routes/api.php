<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/verusers', [LoginController::class, 'getUsers']);
Route::delete('/deleteuser/{id}', [LoginController::class, 'delete']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);
Route::put('/updateusers/{id}', [LoginController::class, 'update']);