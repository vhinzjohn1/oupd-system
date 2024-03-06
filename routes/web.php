<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialCategory;
use App\Models\Project;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Materials Routes and Controller


Route::resource('project', ProjectController::class);
Route::resource('materials', MaterialController::class);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/material-categories', function () {
    $categories = MaterialCategory::all()->pluck('material_category_name');
    return response()->json($categories);
});

Route::middleware('auth')->group(function () {


    // Projects Routes
    Route::get('projects', function () {
        return view('projects');
    })->name('projects');

    Route::view('about', 'about')->name('about');



    Route::view('/pages/list_of_labors', 'pages.list_of_labors')->name('list_of_labors');

    // Routes for Materials
    Route::get('/pages/list_of_materials', function () {
        return view('pages.list_of_materials');
    })->name('list_of_materials');
    // Route to get the Store function in the Material Controller
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');

    // Route to get the update function in the Material Controller
    Route::put('/materials/{id}', [MaterialController::class, 'update'])->name('materials.update');



    // Users Routes
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
