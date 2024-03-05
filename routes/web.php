<?php

use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialCategory;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Materials Routes and Controller





Route::resource('materials', MaterialController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/material-categories', function () {
    $categories = MaterialCategory::all()->pluck('material_category_name');
    return response()->json($categories);
});

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::view('/pages/list_of_labors', 'pages.list_of_labors')->name('list_of_labors');
    Route::get('/pages/list_of_materials', function () {
        return view('pages.list_of_materials');
    })->name('list_of_materials');
    // Routes for Materials
    // Route::get('/pages/list_of_materials', [MaterialController::class, 'index'])->name('materials.index');

    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::put('/materials/{id}', [MaterialController::class, 'update'])->name('materials.update');




    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
