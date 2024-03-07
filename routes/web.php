<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ParticularController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialCategory;
use App\Models\Project;
use App\Http\Controllers\LaborController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Materials Routes and Controller


Route::resource('project', ProjectController::class);
Route::resource('materials', MaterialController::class);
Route::resource('labor', LaborController::class);
Route::resource('particulars', ParticularController::class);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/material-categories', function () {
    $categories = MaterialCategory::all()->pluck('material_category_name');
    return response()->json($categories);
});

Route::middleware('auth')->group(function () {
    // Projects Routes
    Route::get('/pages/projects', function () {
        return view('pages.projects');
    })->name('projects');
    // Project Update Routes
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('project.update');


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


// Routes for Particulars and Project Particular
Route::middleware('auth')->group(function () {

    // Routes for Particular
    Route::get('particular', function () {
        return view('pages.particular.particular');
    })->name('particular');

    // Routes for Project Particular
    Route::get('project-particular', function () {
        return view('pages.project_particular.project_particular');
    })->name('project_particular');

    // Particular Update Routes
    Route::put('/particulars/{id}', [ParticularController::class, 'update'])->name('particulars.update');
    // Particular Delete Routes
    Route::put('/particulars/{particular_id}', [ParticularController::class, 'destroy'])->name('particulars.destroy');


});
