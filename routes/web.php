<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MLEController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectParticularController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialCategory;
use App\Models\Project;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GetAllDataController;
use App\Http\Controllers\ParticularController;
use App\Models\EquipmentCategory;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route to Controller Material Labor Equipment Resource
Route::resource('mle', MLEController::class);

// Materials Routes and Controller
Route::resource('materials', MaterialController::class);
Route::resource('project', ProjectController::class);


Route::resource('labor', LaborController::class);
Route::resource('particulars', ParticularController::class);

Route::resource('projectParticulars', ProjectParticularController::class);


Route::resource('getAllData', GetAllDataController::class);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home_test', [App\Http\Controllers\HomeController::class, 'index'])->name('home_test');
Route::get('/material-categories', function () {
    $categories = MaterialCategory::all()->pluck('material_category_name');
    return response()->json($categories);
});
Route::get('/equipment-categories', function () {
    $categories = EquipmentCategory::all()->pluck('equipment_category_name');
    return response()->json($categories);
});

Route::middleware('auth')->group(function () {

    Route::get('/pages/projects', function () {
        return view('pages.projects');
    })->name('projects');

    Route::get('/pages/projects', [ProjectController::class, 'getProjectData'])->name('projects');

    Route::get('/formatted-data', [ProjectController::class, 'getProjectData']);

    // Project Update Routes
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('project.update');

    Route::view('about', 'about')->name('about');


    // Routes for labors
    Route::get('/pages/list_of_labors', function () {
        return view('pages.list_of_labors');
    })->name('list_of_labors');

    // Route for the index page of labors
    Route::get('/labors', [LaborController::class, 'index'])->name('labors.index');

    // Route to get the Store function in the Labor Controller
    Route::post('/labors', [LaborController::class, 'store'])->name('labors.store');

    // Route to get the update function in the Labor Controller
    Route::put('/labors/{id}', [LaborController::class, 'update'])->name('labors.update');

    Route::view('/pages/list_of_labors', 'pages.list_of_labors')->name('list_of_labors');

    // Routes for Materials
    Route::get('/pages/list_of_materials', function () {
        return view('pages.list_of_materials');
    })->name('list_of_materials');
    // Route to get the Store function in the Material Controller
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');

    // Route to get the update function in the Material Controller
    Route::put('/materials/{id}', [MaterialController::class, 'update'])->name('materials.update');

    // Routes for equipments
    Route::get('/pages/list_of_equipments', function () {
        return view('pages.list_of_equipments');
    })->name('list_of_equipments');

    // Route for the index page of equipments
    Route::get('/equipments', [EquipmentController::class, 'index'])->name('equipments.index');

    // Route to get the Store function in the equipment Controller
    Route::post('/equipments', [EquipmentController::class, 'store'])->name('equipments.store');

    // Route to get the update function in the equipment Controller
    Route::put('/equipments/{id}', [EquipmentController::class, 'update'])->name('equipments.update');

    Route::view('/pages/list_of_equipments', 'pages.list_of_equipments')->name('list_of_equipments');



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
    Route::get('project_particular', function () {
        return view('pages.project_particular.project_particular');
    })->name('project_particular');
    // Project Particular Delete Routes
    Route::delete('/project_particular/{project_particular_id}', [ProjectParticularController::class, 'destroy'])->name('project_particular.destroy');


    // Particular Update Routes
    Route::put('/particulars/{id}', [ParticularController::class, 'update'])->name('particulars.update');
    // Particular Delete Routes
    Route::put('/particulars/{particular_id}', [ParticularController::class, 'destroy'])->name('particulars.destroy');
    Route::resource('particulars', ParticularController::class);

});


// Project Particular Routes:
Route::post('/submit-data', [MLEController::class, 'submitData'])->name('submit.data');

