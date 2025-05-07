<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\ApplianceController;
use App\Http\Controllers\ClothesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\WheelsController;
use App\Http\Controllers\BikesController;
use App\Http\Controllers\SportsController;
use App\Http\Controllers\AthletesController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('Producto', ProductController::class);
Route::resource('/products', ProductController::class);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::resource('Car', CarController::class);
Route::resource('/car', CarController::class);
Route::put('/cars/{id}', [CarController::class, 'update']);
Route::delete('/cars/{id}', [CarController::class, 'destroy']);

Route::resource('House', HouseController::class);
Route::post('/house', [HouseController::class, 'store']);
Route::get('/houses', [HouseController::class, 'getHouses']);
Route::put('/house/{id}', [HouseController::class, 'update']);
Route::delete('/house/{id}', [HouseController::class, 'destroy']);

Route::resource('Appliance', ApplianceController::class);
Route::get('/appliances', [ApplianceController::class, 'getAppliances']);
Route::post('/appliance', [ApplianceController::class, 'store']);
Route::put('/appliance/{id}', [ApplianceController::class, 'update']);
Route::delete('/appliance/{id}', [ApplianceController::class, 'destroy']);

Route::resource('Clothes', ClothesController::class);
Route::get('/clothes', [ClothesController::class, 'getAllClothes']);
Route::post('/clothe', [ClothesController::class, 'store']);
Route::put('/clothe/{id}', [ClothesController::class, 'update']);
Route::delete('/clothe/{id}', [ClothesController::class, 'destroy']);

Route::resource('City', CitiesController::class);
Route::get('/cities', [CitiesController::class, 'getAllCities']);
Route::post('/city', [CitiesController::class, 'store']);
Route::put('/city/{id}', [CitiesController::class, 'update']);
Route::delete('/city/{id}', [CitiesController::class, 'destroy']);

Route::resource('Wheels', WheelsController::class);
Route::get('/wheels', [WheelsController::class, 'getWheels']);
Route::post('/wheel', [WheelsController::class, 'store']);
Route::put('/wheel/{id}', [WheelsController::class, 'update']);
Route::delete('/wheel/{id}', [WheelsController::class, 'destroy']);

Route::resource('Bikes', BikesController::class);
Route::get('/bikes', [BikesController::class, 'getAllBikes']);
Route::post('/bike',[BikesController::class, 'store']);
Route::put('/bike/{id}', [BikesController::class, 'update']);
Route::delete('/bike/{id}', [BikesController::class, 'destroy']);

Route::resource('sport', SportsController::class);

Route::resource('Athlete', AthletesController::class);
require __DIR__ . '/auth.php';
