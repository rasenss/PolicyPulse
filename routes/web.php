<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/policy/{id}', [MainController::class, 'policy'])->name('policy');
Route::get('/education', [MainController::class, 'education'])->name('education');
Route::get('/exam', [MainController::class, 'quiz'])->name('quiz');
Route::post('/exam', [MainController::class, 'submit'])->name('submit');