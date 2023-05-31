<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
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
//Public APIs
Route::controller(AuthController::class)->group(function () {
    Route::post('/login',               'login')     ->name('user.login');
    Route::post('/user',                'store')     ->name('user.store');
    Route::put('/user/email/{id}',      'email')     ->name('user.email');
    Route::put('/user/password/{id}',   'password')  ->name('user.password');
    Route::delete('/user/{id}',         'destroy');
    Route::post('/register',                'register')     ->name('user.register');
});




//Private APIs
Route::middleware(['auth:sanctum'])->group(function () 
{
    Route::post('/logout', [AuthController::class, 'logout']);
});
