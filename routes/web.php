<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('songs',[HomeController::class,'getSongs'])->name('getSongs');
Route::post('createPlaylist',[HomeController::class,'createPlaylist'])->name('createPlaylist');

Route::get('/login',[\App\Http\Controllers\AuthController::class,'login'])->name('login');
Route::get('/callback',[\App\Http\Controllers\AuthController::class,'callback'])->name('callback');
