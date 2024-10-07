<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Admin
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::prefix('/admin')->group(function(){
    Route::prefix('/country')->group(function(){
        Route::get('/add', [CountryController::class, 'getdata']);
        Route::post('/add', [CountryController::class, 'create']);
        Route::get('/list', [CountryController::class, 'index']);
        Route::get('/delete/{id}', [CountryController::class, 'delete'])->name('countryDelete');
    }); 

    Route::prefix('/blog')->group(function(){
        Route::get('/add', [BlogController::class, 'getData']);
        Route::post('/add', [BlogController::class, 'create']);
        Route::get('/list', [BlogController::class, 'index']);
        Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blogEdit');
        Route::post('/edit/{id}', [BlogController::class, 'update']);
        Route::get('/delete/{id}', [BlogController::class, 'delete'])->name('blogDelete');
    });

    Route::prefix('/profile')->group(function(){
        Route::get('/add', [AdminController::class, 'getCountry']);
        Route::post('/add', [AdminController::class, 'create']);
        Route::get('/', [AdminController::class, 'profile']);
        Route::post('/', [AdminController::class, 'update']);
    });
    
    Route::prefix('/category')->group(function(){
        Route::get('/add', [CategoryController::class, 'getCategory']);
        Route::post('/add', [CategoryController::class, 'create']);
        Route::get('/list', [CategoryController::class, 'show']);
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('categoryDelete');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('categoryEdit');
        Route::post('/edit/{id}', [CategoryController::class, 'update']);
    });

    Route::prefix('/brand')->group(function(){
        Route::get('/add', [BrandController::class, 'getBrand']);
        Route::post('/add', [BrandController::class, 'create']);
        Route::get('/list', [BrandController::class, 'show']);
        Route::get('/delete/{id}', [BrandController::class, 'delete'])->name('brandDelete');
    });
});