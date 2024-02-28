<?php

use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Materials Routes and Controller

// Routes for Materials
Route::get('/pages/list_of_materials', [MaterialController::class, 'index'])->name('list_of_materials');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::view('/pages/list_of_labors', 'pages.list_of_labors')->name('list_of_labors');

    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::put('/materials/{id}', [MaterialController::class, 'update'])->name('materials.update');


    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
