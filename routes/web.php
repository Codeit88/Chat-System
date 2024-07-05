<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatsController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/chat', [ChatsController::class, 'index']);
Route::get('messages', [ChatsController::class, 'fetchMessages']);
Route::post('messages', [ChatsController::class, 'sendMessage']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
